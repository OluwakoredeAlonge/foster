<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Support\Str;

class CloudinaryService
{
    private Cloudinary $sdk;

    public function __construct()
    {
        $this->sdk = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key' => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
            ],
            'url' => ['secure' => true],
        ]);
    }

    public function upload($file, string $folder = 'uploads', string $resourceType = 'image'): string
    {
        $options = [
            'folder' => $folder,
            'resource_type' => $resourceType,
        ];

        if ($resourceType === 'raw') {
            // For raw resources, Cloudinary always appends the extension of
            // the *actual source file on disk* — which for an HTTP upload is
            // PHP's own temp buffer file (literally named "phpXXXX.tmp") —
            // regardless of what extension is baked into public_id. Putting
            // ".pdf" in public_id here does NOT work (verified against a
            // live account: it produces "name.pdf.tmp"). The only reliable
            // override is the explicit "format" upload parameter.
            $extension = strtolower((string) $file->getClientOriginalExtension());
            $options['public_id'] = Str::random(24);
            if ($extension) {
                $options['format'] = $extension;
            }
        }

        $result = $this->sdk->uploadApi()->upload($file->getRealPath(), $options);

        return $result['secure_url'];
    }

    /**
     * Fetches an existing (typically our own, e.g. when duplicating a
     * course) remote file and stores it as a brand new, independent
     * Cloudinary asset — Cloudinary supports a URL directly as the upload
     * source. Deliberately NOT the same asset as the source: sharing a
     * public_id between two courses would mean deleting one course's image
     * (or a material) silently breaks the other's.
     */
    public function uploadFromUrl(string $url, string $folder = 'uploads', string $resourceType = 'image'): string
    {
        $options = [
            'folder' => $folder,
            'resource_type' => $resourceType,
        ];

        if ($resourceType === 'raw') {
            $extension = strtolower((string) pathinfo(parse_url($url, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION));
            $options['public_id'] = Str::random(24);
            if ($extension) {
                $options['format'] = $extension;
            }
        }

        $result = $this->sdk->uploadApi()->upload($url, $options);

        return $result['secure_url'];
    }

    public function delete(?string $url): void
    {
        if (! $url || ! str_contains($url, 'res.cloudinary.com')) {
            return;
        }

        $isRaw = str_contains($url, '/raw/upload/');
        $publicId = $this->extractPublicId($url, $isRaw);

        if ($publicId) {
            $this->sdk->uploadApi()->destroy($publicId, ['resource_type' => $isRaw ? 'raw' : 'image']);
        }
    }

    /**
     * Build a download link that forces the given filename via Cloudinary's
     * fl_attachment flag. Needed for raw files uploaded before public_id
     * started carrying the extension, and harmless for files that already
     * have one.
     *
     * The name passed to fl_attachment must NOT contain a dot — Cloudinary
     * parses transformation segments on ".", so "fl_attachment:Foo.pdf"
     * fails with "Invalid flag in transformation: pdf" (verified against a
     * live account). Leaving the extension off is not a limitation though:
     * Cloudinary automatically appends the resource's real extension to the
     * suggested filename, so the browser still saves it as "Foo.pdf".
     */
    public function attachmentUrl(string $url, string $filename): string
    {
        $nameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
        $safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', $nameWithoutExtension);

        return preg_replace('#/upload/#', "/upload/fl_attachment:{$safeName}/", $url, 1);
    }

    private function extractPublicId(string $url, bool $isRaw): ?string
    {
        if ($isRaw) {
            // Raw public_ids include their extension, so nothing to strip.
            if (preg_match('/\/upload\/(?:v\d+\/)?(.+)$/', $url, $matches)) {
                return $matches[1];
            }

            return null;
        }

        // https://res.cloudinary.com/{cloud}/image/upload/v{version}/{folder}/{file}.{ext}
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)\.\w+$/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
