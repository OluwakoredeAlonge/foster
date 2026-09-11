<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\PartnerCoursesApiException;
use App\Http\Controllers\Controller;
use App\Models\ExternalCourseVisibility;
use App\Services\PartnerCoursesClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Public, tokenless catalog endpoints for the static Fosterheirs site.
 *
 * These proxy the partner courses API server-side and strip anything not
 * on the public_fields allow-list (see config/course_catalog.php) before
 * the response ever reaches a browser. Gated content (week/resource
 * titles, YouTube links, PDF downloads) never passes through here.
 */
class PublicCourseController extends Controller
{
    public function __construct(protected PartnerCoursesClient $courses) {}

    public function index(Request $request): JsonResponse
    {
        $page = max(1, (int) $request->integer('page', 1));

        $cacheKey = "public-courses:list:{$page}";

        try {
            $result = Cache::remember(
                $cacheKey,
                (int) config('course_catalog.cache_ttl', 300),
                fn () => $this->courses->list($page)
            );
        } catch (PartnerCoursesApiException $e) {
            Log::error('Partner courses API list request failed.', ['error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Course catalog is temporarily unavailable.',
            ], 502);
        }

        $hiddenSlugs = ExternalCourseVisibility::hiddenSlugs();
        $visibleItems = array_values(array_filter(
            $result['items'],
            fn (array $course) => ! in_array($course['slug'] ?? null, $hiddenSlugs, true)
        ));

        // Filtering happens after the partner's own pagination, so on a
        // page with hidden courses this can return fewer items than
        // `meta.per_page` says — acceptable while the catalog is small
        // (single page); `meta.total` still reflects the partner's count,
        // not what's actually visible here.
        return response()->json([
            'data' => array_map($this->trim(...), $visibleItems),
            'meta' => Arr::only($result['meta'], ['current_page', 'last_page', 'per_page', 'total']),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        if (in_array($slug, ExternalCourseVisibility::hiddenSlugs(), true)) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        $cacheKey = "public-courses:show:{$slug}";

        try {
            $course = Cache::remember(
                $cacheKey,
                (int) config('course_catalog.cache_ttl', 300),
                fn () => $this->courses->find($slug)
            );
        } catch (PartnerCoursesApiException $e) {
            Log::error('Partner courses API show request failed.', ['slug' => $slug, 'error' => $e->getMessage()]);

            return response()->json([
                'message' => 'Course catalog is temporarily unavailable.',
            ], 502);
        }

        if ($course === null) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        return response()->json(['data' => $this->trim($course)]);
    }

    /**
     * Reduce a raw partner course record down to the public allow-list and
     * attach a storefront link, since this proxy never exposes gated content.
     *
     * @param  array<string, mixed>  $course
     * @return array<string, mixed>
     */
    protected function trim(array $course): array
    {
        $safe = Arr::only($course, config('course_catalog.public_fields', []));

        $template = config('course_catalog.storefront_url_template');
        if ($template && isset($course['slug'])) {
            $safe['purchase_url'] = str_replace('{slug}', $course['slug'], $template);
        }

        return $safe;
    }
}
