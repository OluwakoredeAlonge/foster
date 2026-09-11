<?php

namespace App\Services;

use App\Exceptions\PartnerCoursesApiException;
use App\Models\ExternalCourseVisibility;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class PartnerCoursesClient
{
    /**
     * Fetch one page of the partner's course catalogue.
     *
     * @return array{items: array<int, array<string, mixed>>, meta: array<string, mixed>}
     */
    public function list(int $page = 1): array
    {
        $response = $this->send(fn () => $this->request()->get('/api/courses', ['page' => $page]));

        if (! $response->successful()) {
            throw new PartnerCoursesApiException(
                "Partner courses API returned {$response->status()} for course list."
            );
        }

        $body = $response->json();

        return [
            'items' => $body['data'] ?? (is_array($body) ? $body : []),
            'meta' => $body['meta'] ?? [],
        ];
    }

    /**
     * Fetch a single course by slug. Returns null when the partner reports 404.
     *
     * @return array<string, mixed>|null
     */
    public function find(string $slug): ?array
    {
        $response = $this->send(fn () => $this->request()->get("/api/courses/{$slug}"));

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new PartnerCoursesApiException(
                "Partner courses API returned {$response->status()} for course '{$slug}'."
            );
        }

        $body = $response->json();

        return $body['data'] ?? $body;
    }

    /**
     * One page of the catalogue, admin-hidden courses excluded and every
     * course reduced to the public allow-list. What both the homepage
     * teaser and the full course catalog page render.
     *
     * @return array{items: array<int, array<string, mixed>>, meta: array<string, mixed>}
     */
    public function visiblePublicList(int $page = 1): array
    {
        $result = $this->list($page);
        $hiddenSlugs = ExternalCourseVisibility::hiddenSlugs();

        $visible = array_values(array_filter(
            $result['items'],
            fn (array $course) => ! in_array($course['slug'] ?? null, $hiddenSlugs, true)
        ));

        return [
            'items' => array_map($this->toPublicArray(...), $visible),
            'meta' => $result['meta'],
        ];
    }

    /**
     * Reduce a raw partner course record down to the public allow-list and
     * attach a storefront link. This proxy never exposes gated content
     * (week/resource titles, YouTube links, PDF downloads).
     *
     * The partner API returns its own canonical `url` for each course —
     * that's the real page it's bought/taken on, so it's used as-is
     * whenever present. The slug-templated URL is kept only as a
     * fallback for older/partial partner responses that don't include it.
     *
     * @param  array<string, mixed>  $course
     * @return array<string, mixed>
     */
    public function toPublicArray(array $course): array
    {
        $safe = Arr::only($course, config('course_catalog.public_fields', []));

        if (! empty($course['url'])) {
            $safe['purchase_url'] = $course['url'];
        } elseif (($template = config('course_catalog.storefront_url_template')) && isset($course['slug'])) {
            $safe['purchase_url'] = str_replace('{slug}', $course['slug'], $template);
        }

        return $safe;
    }

    protected function request(): PendingRequest
    {
        $baseUrl = config('course_catalog.base_url');
        $token = config('course_catalog.token');

        if (empty($baseUrl) || empty($token)) {
            throw new PartnerCoursesApiException(
                'COURSES_API_BASE_URL / COURSES_API_TOKEN are not configured.'
            );
        }

        return Http::withToken($token)
            ->baseUrl(rtrim($baseUrl, '/'))
            ->timeout((int) config('course_catalog.timeout', 15))
            // The partner app is hosted on Laravel Cloud, which sleeps
            // when idle — the first request after a quiet spell pays a
            // cold-start cost that a single short-timeout attempt can
            // easily miss, surfacing as "could not reach the API" even
            // though the app is fine once it's warm. Retrying once after
            // a beat covers exactly that case without masking a real
            // outage (it still gives up and surfaces the error normally
            // if the second attempt also fails).
            //
            // `when` restricts retries to actual connection failures —
            // without it, Laravel's HTTP client retries (and then
            // auto-throws on) ANY non-2xx response, including a clean
            // 404 from find() or a real 401, which list()/find() below
            // already handle themselves by inspecting the response.
            // `throw: false` stops it from throwing on those responses
            // itself once retries are exhausted, leaving that decision
            // to the calling method as before.
            ->retry(2, 1500, when: fn ($exception) => $exception instanceof ConnectionException, throw: false)
            ->acceptJson();
    }

    /**
     * @param  callable(): Response  $callback
     */
    protected function send(callable $callback): Response
    {
        try {
            return $callback();
        } catch (ConnectionException $e) {
            throw new PartnerCoursesApiException('Could not reach the partner courses API.', previous: $e);
        }
    }
}
