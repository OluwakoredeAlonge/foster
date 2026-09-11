<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PartnerCoursesApiException;
use App\Http\Controllers\Controller;
use App\Models\ExternalCourseVisibility;
use App\Services\PartnerCoursesClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Lets the admin curate which courses pulled from the partner API
 * (heirsmultispecialisthospital.laravel.cloud) actually show up in the
 * homepage's Courses section — the partner may publish something Dr.
 * Soje doesn't want featured on the Fosterheirs site.
 */
class ExternalCourseController extends Controller
{
    public function index(PartnerCoursesClient $client): View
    {
        $error = null;
        $courses = [];

        try {
            $page = 1;
            do {
                $result = $client->list($page);
                $courses = [...$courses, ...$result['items']];
                $lastPage = (int) ($result['meta']['last_page'] ?? 1);
                $page++;
            } while ($page <= $lastPage);
        } catch (PartnerCoursesApiException $e) {
            $error = 'Could not reach the partner courses API. Check COURSES_API_BASE_URL / COURSES_API_TOKEN in .env.';
        }

        $hidden = ExternalCourseVisibility::where('is_visible', false)->pluck('id', 'slug');

        return view('admin.external-courses.index', compact('courses', 'hidden', 'error'));
    }

    public function toggle(string $slug): RedirectResponse
    {
        $visibility = ExternalCourseVisibility::firstOrCreate(['slug' => $slug], ['is_visible' => true]);
        $visibility->update(['is_visible' => ! $visibility->is_visible]);

        return back()->with(
            'success',
            $visibility->is_visible
                ? 'Course is now shown on the public site.'
                : 'Course is now hidden from the public site.'
        );
    }
}
