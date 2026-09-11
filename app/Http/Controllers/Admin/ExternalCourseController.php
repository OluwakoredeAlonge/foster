<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\PartnerCoursesApiException;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\ExternalCourseVisibility;
use App\Services\CloudinaryService;
use App\Services\PartnerCoursesClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Lets the admin curate which courses pulled from the partner API
 * (heirsmultispecialisthospital.laravel.cloud) actually show up in the
 * homepage's Courses section — the partner may publish something Dr.
 * Soje doesn't want featured on the Fosterheirs site. Also lets her
 * "import" one into this app's own database (see import() below), so it
 * becomes a fully independent local course she can edit here.
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
        $importedSlugs = Course::whereIn('slug', array_column($courses, 'slug'))->pluck('slug')->all();

        return view('admin.external-courses.index', compact('courses', 'hidden', 'error', 'importedSlugs'));
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

    /**
     * Copies a pulled course — title, pricing, weeks, YouTube resources
     * and downloadable PDFs — into a brand new local Course row. Images
     * and PDFs are re-uploaded as fresh Cloudinary assets (not shared
     * references) so this copy has nothing left tying it back to the
     * partner site: from this point on it lives entirely in Fosterheirs'
     * own database, and editing or deleting it here can never affect, and
     * is never affected by, the source course on the partner's site.
     *
     * Saved unpublished so the admin reviews it in /admin/courses before
     * it goes live, and automatically hidden from the "Pulled Courses"
     * public feed so the same course doesn't appear twice.
     */
    public function import(string $slug, PartnerCoursesClient $client, CloudinaryService $cloudinary): RedirectResponse
    {
        if (Course::where('slug', $slug)->exists()) {
            return back()->with('error', 'This course was already imported — find it under Course Platform > Courses.');
        }

        try {
            $external = $client->find($slug);
        } catch (PartnerCoursesApiException $e) {
            return back()->with('error', 'Could not reach the partner courses API to import this course.');
        }

        if (! $external) {
            return back()->with('error', 'That course could not be found on the partner API.');
        }

        $course = DB::transaction(function () use ($external, $cloudinary) {
            $categoryName = $external['category']['name'] ?? $external['type'] ?? null;
            $category = $categoryName ? CourseCategory::firstOrCreate(['name' => $categoryName]) : null;

            $course = Course::create([
                'title' => $external['title'],
                'slug' => $external['slug'],
                'type' => $external['type'] ?? 'Course',
                'details' => $external['details'] ?? null,
                'price' => $external['price'] ?? 0,
                'original_price' => $external['original_price'] ?? null,
                'course_image_path' => ! empty($external['image_url'])
                    ? $cloudinary->uploadFromUrl($external['image_url'], 'courses/images')
                    : null,
                'course_category_id' => $category?->id,
                'has_certificate' => $external['has_certificate'] ?? false,
                'access_duration_months' => $external['access_duration_months'] ?? null,
                'requires_registration' => $external['requires_registration'] ?? false,
                'is_published' => false,
                'created_by' => Auth::id(),
            ]);

            foreach (array_values($external['weeks'] ?? []) as $weekIndex => $week) {
                $courseWeek = $course->weeks()->create([
                    'week_number' => $week['week_number'] ?? $weekIndex + 1,
                    'title' => $week['title'] ?? null,
                    'details' => $week['details'] ?? null,
                    'sort_order' => $weekIndex,
                ]);

                foreach (array_values($week['resources'] ?? []) as $resourceIndex => $resource) {
                    if (empty($resource['title']) || empty($resource['youtube_url'])) {
                        continue;
                    }

                    $courseWeek->resources()->create([
                        'title' => $resource['title'],
                        'youtube_url' => $resource['youtube_url'],
                        'sort_order' => $resourceIndex,
                    ]);
                }
            }

            foreach (array_values($external['materials'] ?? []) as $materialIndex => $material) {
                if (empty($material['download_url'])) {
                    continue;
                }

                $course->materials()->create([
                    'label' => $material['label'] ?? 'Material',
                    'file_path' => $cloudinary->uploadFromUrl($material['download_url'], 'courses/materials', 'raw'),
                    'week_number' => $material['week_number'] ?? null,
                    'sort_order' => $materialIndex,
                ]);
            }

            return $course;
        });

        ExternalCourseVisibility::updateOrCreate(['slug' => $course->slug], ['is_visible' => false]);

        return redirect()->route('admin.courses.edit', $course)->with(
            'success',
            "\"{$course->title}\" imported. It's saved locally as a draft and no longer tied to the partner site — review it, then publish when ready."
        );
    }
}
