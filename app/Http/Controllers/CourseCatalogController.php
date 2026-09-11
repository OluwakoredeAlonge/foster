<?php

namespace App\Http\Controllers;

use App\Exceptions\PartnerCoursesApiException;
use App\Models\Course;
use App\Services\PartnerCoursesClient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

/**
 * The full, paginated listing of every course a visitor can act on from
 * this site — local, imported courses (their own page and checkout
 * here) first, then still-external "pulled" courses (link out to the
 * partner's own page) filling the rest. What the homepage's "Load More
 * Courses" button sends visitors to, since the homepage itself only
 * teases the first few.
 */
class CourseCatalogController extends Controller
{
    private const PER_PAGE = 12;

    public function __construct(protected PartnerCoursesClient $courses) {}

    public function index(Request $request): View
    {
        $page = max(1, (int) $request->integer('page', 1));
        $error = null;

        $localCourses = Course::where('is_published', true)
            ->with('category')
            ->latest()
            ->get()
            ->map->toPublicArray()
            ->all();

        $externalCourses = [];

        try {
            $externalPage = 1;
            do {
                $result = $this->courses->visiblePublicList($externalPage);
                $externalCourses = [...$externalCourses, ...$result['items']];
                $lastPage = (int) ($result['meta']['last_page'] ?? 1);
                $externalPage++;
            } while ($externalPage <= $lastPage);
        } catch (PartnerCoursesApiException $e) {
            Log::error('Partner courses API list request failed.', ['error' => $e->getMessage()]);
            // Only a hard error (nothing at all to show) blocks the
            // page — if local courses loaded fine, show those instead
            // of hiding a working part of the catalog behind this.
            if (empty($localCourses)) {
                $error = 'Our course catalog is temporarily unavailable. Please check back shortly.';
            }
        }

        $allCourses = [...$localCourses, ...$externalCourses];

        $courses = new LengthAwarePaginator(
            array_slice($allCourses, ($page - 1) * self::PER_PAGE, self::PER_PAGE),
            count($allCourses),
            self::PER_PAGE,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('course-catalog', compact('courses', 'error'));
    }
}
