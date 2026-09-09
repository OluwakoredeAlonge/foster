<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseResourceProgress;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'newest');
        $categorySlug = $request->input('category', '');

        $query = Course::where('is_published', true)->with('category');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($categorySlug) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
        }

        match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $courses = $query->paginate(12)->appends($request->query());
        $categories = CourseCategory::orderBy('sort_order')->withCount([
            'courses' => fn ($q) => $q->where('is_published', true),
        ])->get();

        return view('courses.index', compact('courses', 'search', 'sort', 'categories', 'categorySlug'));
    }

    public function show(Course $course)
    {
        abort_unless($course->is_published, 404);

        $course->load([
            'category',
            'weeks.resources',
            'materials',
            'reviews' => fn ($query) => $query->latest()->limit(50)->with('user'),
        ]);

        $myReview = auth()->check()
            ? $course->reviews->firstWhere('user_id', auth()->id())
            : null;

        $myOrder = $course->orderFor(auth()->user());
        $hasAccess = $myOrder?->hasActiveAccess() ?? false;

        // Materials tagged with a week_number that no longer matches any of
        // this course's current weeks (e.g. the week was later removed)
        // fall back to the general list rather than silently disappearing.
        $weekNumbers = $course->weeks->pluck('week_number')->all();
        $generalMaterials = $course->materials->filter(
            fn ($material) => ! $material->week_number || ! in_array($material->week_number, $weekNumbers)
        );

        // "week_number:sort_order" -> true, for the resources this student
        // has ticked off. Keyed this way (not by resource id) because
        // resources are recreated with new ids every time the course is
        // saved — see the course_resource_progress migration.
        $completedResourceKeys = [];
        if ($hasAccess && auth()->check()) {
            $completedResourceKeys = CourseResourceProgress::where('user_id', auth()->id())
                ->where('course_id', $course->id)
                ->get()
                ->map(fn ($p) => "{$p->week_number}:{$p->resource_sort_order}")
                ->flip()
                ->map(fn () => true)
                ->all();
        }

        return view('courses.show', compact(
            'course', 'myReview', 'myOrder', 'hasAccess', 'generalMaterials', 'completedResourceKeys'
        ));
    }
}
