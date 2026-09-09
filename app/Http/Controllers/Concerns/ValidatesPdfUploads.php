<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;

trait ValidatesPdfUploads
{
    /**
     * Laravel's `mimes:pdf` rule trusts PHP's fileinfo-guessed MIME type,
     * which misidentifies a number of genuinely valid PDFs (invoice/receipt
     * exporters in particular) as something other than application/pdf and
     * rejects them outright.
     *
     * The browser-reported extension is trusted first and is enough on its
     * own — it's the same signal the rest of this app already relies on
     * (Cloudinary's `format`, the displayed material label) and is reliably
     * correct for a file the admin picked themselves. The "%PDF-" file
     * signature is only checked as a fallback for files with no clear .pdf
     * extension, and a failed *read* (as opposed to a confirmed bad header)
     * is never treated as a rejection — an unrelated I/O hiccup on one file
     * in a multi-file upload shouldn't reject a perfectly valid PDF.
     */
    private function isPdfRule(): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) {
            if (! $value instanceof UploadedFile) {
                return;
            }

            if (strtolower((string) $value->getClientOriginalExtension()) === 'pdf') {
                return;
            }

            $realPath = $value->getRealPath();
            $header = ($realPath && is_readable($realPath))
                ? @file_get_contents($realPath, false, null, 0, 5)
                : false;

            if ($header !== false && $header !== '%PDF-') {
                $fail('The '.$attribute.' must be a PDF file.');
            }
        };
    }
}
