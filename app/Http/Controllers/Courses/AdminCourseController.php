<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Concerns\ValidatesPdfUploads;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseMaterial;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminCourseController extends Controller
{
    use ValidatesPdfUploads;

    public function index()
    {
        $courses = Course::with('category')->withCount('weeks')->latest()->paginate(20);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = CourseCategory::orderBy('sort_order')->get();

        return view('admin.courses.form', ['course' => null, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateCourse($request);

        $course = DB::transaction(function () use ($validated, $request) {
            $course = Course::create([
                'title' => $validated['title'],
                'type' => $validated['type'] ?? 'Course',
                'details' => $validated['details'] ?? null,
                'price' => $validated['price'],
                'original_price' => $validated['original_price'] ?? null,
                'is_published' => $request->boolean('is_published', true),
                'created_by' => Auth::id(),
                'course_image_path' => $this->uploadCourseImage($request),
                'course_image_fit' => $validated['course_image_fit'] ?? 'cover',
                'course_category_id' => $validated['course_category_id'] ?? null,
                'has_certificate' => $request->boolean('has_certificate'),
                'access_duration_months' => $validated['access_duration_months'] ?? null,
                'requires_registration' => $request->boolean('requires_registration'),
                'is_cohort' => $request->boolean('is_cohort'),
                'cohort_starts_at' => $validated['cohort_starts_at'] ?? null,
                'waitlist_url' => $validated['waitlist_url'] ?? null,
            ]);

            $this->syncWeeks($course, $validated['weeks'] ?? []);
            $this->addMaterials($course, $request);

            return $course;
        });

        return redirect()->route('admin.courses.edit', $course)->with('success', "Course \"{$course->title}\" created.");
    }

    public function edit(Course $course)
    {
        $course->load('weeks.resources', 'materials');
        $categories = CourseCategory::orderBy('sort_order')->get();

        return view('admin.courses.form', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $this->validateCourse($request);

        DB::transaction(function () use ($validated, $request, $course) {
            $data = [
                'title' => $validated['title'],
                'type' => $validated['type'] ?? 'Course',
                'details' => $validated['details'] ?? null,
                'price' => $validated['price'],
                'original_price' => $validated['original_price'] ?? null,
                'is_published' => $request->boolean('is_published', true),
                'course_image_fit' => $validated['course_image_fit'] ?? 'cover',
                'course_category_id' => $validated['course_category_id'] ?? null,
                'has_certificate' => $request->boolean('has_certificate'),
                'access_duration_months' => $validated['access_duration_months'] ?? null,
                'requires_registration' => $request->boolean('requires_registration'),
                'is_cohort' => $request->boolean('is_cohort'),
                'cohort_starts_at' => $validated['cohort_starts_at'] ?? null,
                'waitlist_url' => $validated['waitlist_url'] ?? null,
            ];

            if ($request->hasFile('course_image')) {
                app(CloudinaryService::class)->delete($course->course_image_path);
                $data['course_image_path'] = $this->uploadCourseImage($request);
            }

            $course->update($data);

            $this->syncWeeks($course, $validated['weeks'] ?? []);
            $this->addMaterials($course, $request);
        });

        return redirect()->route('admin.courses.edit', $course)->with('success', "Course \"{$course->title}\" updated.");
    }

    public function destroy(Course $course)
    {
        app(CloudinaryService::class)->delete($course->course_image_path);

        foreach ($course->materials as $material) {
            app(CloudinaryService::class)->delete($material->file_path);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }

    /**
     * Duplicates a course — including its weeks, resources, and
     * materials — as a new, fully independent draft. The image and PDF
     * materials are re-uploaded to Cloudinary as separate assets (not
     * shared references) so deleting the original later can never affect
     * the copy. Always created unpublished so the admin can review price,
     * title, and content before it goes live on the storefront.
     */
    public function duplicate(Course $course)
    {
        $course->load('weeks.resources', 'materials');
        $cloudinary = app(CloudinaryService::class);

        $newCourse = DB::transaction(function () use ($course, $cloudinary) {
            $newCourse = Course::create([
                'title' => "{$course->title} (Copy)",
                'type' => $course->type,
                'details' => $course->details,
                'price' => $course->price,
                'original_price' => $course->original_price,
                'course_image_path' => $course->course_image_path
                    ? $cloudinary->uploadFromUrl($course->course_image_path, 'courses/images')
                    : null,
                'course_image_fit' => $course->course_image_fit,
                'course_category_id' => $course->course_category_id,
                'has_certificate' => $course->has_certificate,
                'access_duration_months' => $course->access_duration_months,
                'requires_registration' => $course->requires_registration,
                'is_cohort' => $course->is_cohort,
                'cohort_starts_at' => $course->cohort_starts_at,
                'waitlist_url' => $course->waitlist_url,
                'is_published' => false,
                'created_by' => Auth::id(),
            ]);

            foreach ($course->weeks as $week) {
                $newWeek = $newCourse->weeks()->create([
                    'week_number' => $week->week_number,
                    'title' => $week->title,
                    'details' => $week->details,
                    'sort_order' => $week->sort_order,
                ]);

                foreach ($week->resources as $resource) {
                    $newWeek->resources()->create([
                        'title' => $resource->title,
                        'youtube_url' => $resource->youtube_url,
                        'sort_order' => $resource->sort_order,
                    ]);
                }
            }

            foreach ($course->materials as $material) {
                $newCourse->materials()->create([
                    'label' => $material->label,
                    'file_path' => $cloudinary->uploadFromUrl($material->file_path, 'courses/materials', 'raw'),
                    'week_number' => $material->week_number,
                    'sort_order' => $material->sort_order,
                ]);
            }

            return $newCourse;
        });

        return redirect()->route('admin.courses.edit', $newCourse)
            ->with('success', "Course duplicated as \"{$newCourse->title}\". It's saved as a draft — review it and publish when ready.");
    }

    public function destroyCourseImage(Course $course)
    {
        app(CloudinaryService::class)->delete($course->course_image_path);
        $course->update(['course_image_path' => null]);

        return back()->with('success', 'Course image removed.');
    }

    public function destroyMaterial(Course $course, CourseMaterial $material)
    {
        abort_unless($material->course_id === $course->id, 404);

        app(CloudinaryService::class)->delete($material->file_path);
        $material->delete();

        return back()->with('success', 'File removed.');
    }

    /**
     * A course_image (was 5MB) plus one or more PDF materials (were 10MB
     * each) can add up to well over the server's real post_max_size in a
     * single submission. When that happens the request is rejected before
     * it ever reaches Laravel — no validation error, no log entry, the
     * connection just drops — which from the admin's side looks exactly
     * like "editing doesn't work." Confirmed directly against this app's
     * actual hosting: post_max_size is 9MB (9437184 bytes) — not the
     * larger value php.ini reports for other SAPIs on the same box. These
     * caps leave real headroom under that (multipart boundaries/headers,
     * CSRF token, and the weeks/resources text fields all add to the
     * total too), and combinedUploadSizeRule() below backstops it with a
     * clear error for anything that still gets through.
     */
    private const COURSE_IMAGE_MAX_KB = 2048;   // 2MB

    private const MATERIAL_MAX_KB = 4096;       // 4MB per PDF

    private const COMBINED_UPLOAD_MAX_KB = 7168; // 7MB total per save

    private function validateCourse(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'max:50'],
            'details' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'course_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:'.self::COURSE_IMAGE_MAX_KB],
            'course_image_fit' => ['nullable', 'in:cover,contain'],
            'course_category_id' => ['nullable', 'exists:course_categories,id'],
            'has_certificate' => ['nullable', 'boolean'],
            'access_duration_months' => ['nullable', 'integer', 'min:1', 'max:'.Course::MAX_ACCESS_DURATION_MONTHS],
            'requires_registration' => ['nullable', 'boolean'],
            'is_cohort' => ['nullable', 'boolean'],
            'cohort_starts_at' => ['nullable', 'date'],
            'waitlist_url' => ['nullable', 'required_if:is_cohort,1', 'url', 'max:500'],
            'materials' => ['nullable', 'array'],
            'materials.*' => ['file', 'max:'.self::MATERIAL_MAX_KB, $this->isPdfRule()],
            'material_weeks' => ['nullable', 'array'],
            'material_weeks.*' => ['nullable', 'integer', 'min:1'],
            'is_published' => ['nullable', 'boolean'],
            'weeks' => ['nullable', 'array'],
            'weeks.*.title' => ['nullable', 'string', 'max:255'],
            'weeks.*.details' => ['nullable', 'string', 'max:2000'],
            'weeks.*.resources' => ['nullable', 'array'],
            'weeks.*.resources.*.title' => ['required_with:weeks.*.resources.*.youtube_url', 'nullable', 'string', 'max:255'],
            'weeks.*.resources.*.youtube_url' => ['required_with:weeks.*.resources.*.title', 'nullable', 'url', 'max:500'],
        ]);

        // A whole-request check, not a per-field one: attaching this to a
        // single field's rule chain (e.g. course_image) means Laravel skips
        // it whenever that specific field is absent — which is exactly the
        // common case of "just adding materials, no new image." after()
        // always runs, regardless of which files are actually present.
        $validator->after(function ($validator) use ($request) {
            $totalKb = 0;
            if ($request->hasFile('course_image')) {
                $totalKb += $request->file('course_image')->getSize() / 1024;
            }
            foreach ($request->file('materials', []) as $file) {
                if ($file) {
                    $totalKb += $file->getSize() / 1024;
                }
            }

            if ($totalKb > self::COMBINED_UPLOAD_MAX_KB) {
                $maxMb = round(self::COMBINED_UPLOAD_MAX_KB / 1024, 1);
                $validator->errors()->add(
                    'course_image',
                    "The course image and PDF materials in this save add up to more than {$maxMb}MB combined. Save the image and materials in separate steps."
                );
            }
        });

        return $validator->validate();
    }

    private function uploadCourseImage(Request $request): ?string
    {
        if (! $request->hasFile('course_image')) {
            return null;
        }

        return app(CloudinaryService::class)->upload($request->file('course_image'), 'courses/images');
    }

    private function addMaterials(Course $course, Request $request): void
    {
        if (! $request->hasFile('materials')) {
            return;
        }

        $nextSortOrder = $course->materials()->max('sort_order') + 1;
        $cloudinary = app(CloudinaryService::class);
        $weekSelections = $request->input('material_weeks', []);

        $index = 0;
        foreach ($request->file('materials') as $key => $file) {
            if (! $file) {
                continue;
            }

            $course->materials()->create([
                'label' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_path' => $cloudinary->upload($file, 'courses/materials', 'raw'),
                'week_number' => $weekSelections[$key] ?? null,
                'sort_order' => $nextSortOrder + $index,
            ]);
            $index++;
        }
    }

    private function syncWeeks(Course $course, array $weeks): void
    {
        $course->weeks()->delete();

        foreach (array_values($weeks) as $weekIndex => $week) {
            if (empty($week['title']) && empty($week['details']) && empty($week['resources'])) {
                continue;
            }

            $courseWeek = $course->weeks()->create([
                'week_number' => $weekIndex + 1,
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
    }
}
