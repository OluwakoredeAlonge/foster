<?php

namespace App\Services;

use App\Exceptions\PartnerCoursesApiException;
use Illuminate\Http\Client\ConnectionException;
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

    protected function request(): \Illuminate\Http\Client\PendingRequest
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
            ->timeout((int) config('course_catalog.timeout', 5))
            ->acceptJson();
    }

    /**
     * @param  callable(): \Illuminate\Http\Client\Response  $callback
     */
    protected function send(callable $callback): \Illuminate\Http\Client\Response
    {
        try {
            return $callback();
        } catch (ConnectionException $e) {
            throw new PartnerCoursesApiException('Could not reach the partner courses API.', previous: $e);
        }
    }
}
