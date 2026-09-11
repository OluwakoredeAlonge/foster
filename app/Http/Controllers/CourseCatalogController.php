<?php

namespace App\Http\Controllers;

use App\Exceptions\PartnerCoursesApiException;
use App\Services\PartnerCoursesClient;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

/**
 * The full, paginated listing of courses pulled from the partner API —
 * what the homepage's "Load More Courses" button sends visitors to,
 * since the homepage itself only teases the first few.
 */
class CourseCatalogController extends Controller
{
    public function __construct(protected PartnerCoursesClient $courses) {}

    public function index(Request $request): View
    {
        $page = max(1, (int) $request->integer('page', 1));
        $error = null;
        $items = [];
        $meta = ['current_page' => 1, 'last_page' => 1, 'per_page' => 12, 'total' => 0];

        try {
            $result = $this->courses->visiblePublicList($page);
            $items = $result['items'];
            $meta = $result['meta'] ?: $meta;
        } catch (PartnerCoursesApiException $e) {
            Log::error('Partner courses API list request failed.', ['error' => $e->getMessage()]);
            $error = 'Our course catalog is temporarily unavailable. Please check back shortly.';
        }

        $courses = new LengthAwarePaginator(
            $items,
            (int) ($meta['total'] ?? count($items)),
            (int) ($meta['per_page'] ?? 12),
            (int) ($meta['current_page'] ?? $page),
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('course-catalog', compact('courses', 'error'));
    }
}
