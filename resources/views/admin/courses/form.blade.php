@extends('layouts.admin')

@section('title', $course ? 'Edit Course' : 'Add Course')

@section('content')
@php
    // After a failed submit, Laravel flashes the posted data via old() — use
    // that (so whatever the admin typed survives the reload) instead of
    // falling back to the DB, which would otherwise silently discard any
    // weeks/resources they'd just added or edited. Checked via
    // hasOldInput() rather than old('weeks') truthiness: if the admin
    // removed every week before hitting an unrelated validation error, the
    // browser submits no "weeks" key at all, and a plain truthiness check
    // can't tell that apart from "this is a fresh page load" — it would
    // wrongly resurrect the deleted weeks from the DB.
    $weeksData = session()->hasOldInput()
        ? collect(old('weeks', []))->map(fn ($week) => [
            'title' => $week['title'] ?? '',
            'details' => $week['details'] ?? '',
            'resources' => collect($week['resources'] ?? [])->map(fn ($r) => [
                'title' => $r['title'] ?? '',
                'youtube_url' => $r['youtube_url'] ?? '',
            ])->values(),
        ])->values()
        : ($course
            ? $course->weeks->map(fn ($w) => [
                'title' => $w->title,
                'details' => $w->details,
                'resources' => $w->resources->map(fn ($r) => ['title' => $r->title, 'youtube_url' => $r->youtube_url])->values(),
            ])->values()
            : []);
@endphp
<div class="flex-1 p-4 sm:p-6" x-data="courseForm({ weeks: @js($weeksData) })">

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
                {{ $course ? 'Edit Course' : 'Add New Course' }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ $course ? 'Update course details, pricing and weekly content' : 'Create a new course for the public storefront' }}
            </p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Courses
        </a>
    </div>

    {{--
        IMPORTANT: this is the ONE form on this page. Deleting the course
        image, a PDF, or the whole course happens via standalone <form>
        elements rendered further down (outside this form) and wired to
        their trigger buttons via the HTML "form" attribute. Nesting a
        second <form> inside this one is invalid HTML — browsers merge the
        two, and the inner form's @method('DELETE') can silently override
        this form's @method('PUT') on submit, turning "delete one file"
        into "delete the whole course".
    --}}
    <form method="POST"
          action="{{ $course ? route('admin.courses.update', $course) : route('admin.courses.store') }}"
          enctype="multipart/form-data"
          @submit="return checkCombinedUploadSize($event)">
        @csrf
        @if($course)
            @method('PUT')
        @endif

        <p id="combinedUploadError" class="hidden mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-medium"></p>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Main column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Basic info --}}
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Course Title</label>
                            <input type="text" name="title" required value="{{ old('title', $course->title ?? '') }}"
                                placeholder="e.g., CERTIFIED HEALTHCARE ASSISTANT"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('title') border-red-400 @else border-gray-300 @enderror">
                            @error('title')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Type</label>
                            <input type="text" name="type" value="{{ old('type', $course->type ?? 'Course') }}"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('type') border-red-400 @else border-gray-300 @enderror">
                            @error('type')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Category</label>
                            <select name="course_category_id"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('course_category_id') border-red-400 @else border-gray-300 @enderror">
                                <option value="">No category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (string) old('course_category_id', $course->course_category_id ?? '') === (string) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('course_category_id')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Price (₦)</label>
                            <input type="number" name="price" step="0.01" min="0" required
                                value="{{ old('price', $course->price ?? '') }}"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price') border-red-400 @else border-gray-300 @enderror">
                            @error('price')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Original Price (₦) <span class="text-gray-400 font-normal">optional, shown struck-through</span></label>
                            <input type="number" name="original_price" step="0.01" min="0"
                                value="{{ old('original_price', $course->original_price ?? '') }}"
                                class="w-full max-w-xs px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('original_price') border-red-400 @else border-gray-300 @enderror">
                            @error('original_price')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Details <span class="text-gray-400 font-normal">shown in the Details tab</span></label>
                            <textarea name="details" rows="5"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('details') border-red-400 @else border-gray-300 @enderror">{{ old('details', $course->details ?? '') }}</textarea>
                            @error('details')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Access Duration</label>
                            @php
                                $currentDuration = old('access_duration_months', $course->access_duration_months ?? '');
                            @endphp
                            <select name="access_duration_months"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('access_duration_months') border-red-400 @else border-gray-300 @enderror">
                                <option value="" {{ $currentDuration === '' || $currentDuration === null ? 'selected' : '' }}>Lifetime access</option>
                                @for($m = 1; $m <= \App\Models\Course::MAX_ACCESS_DURATION_MONTHS; $m++)
                                    <option value="{{ $m }}" {{ (string) $currentDuration === (string) $m ? 'selected' : '' }}>
                                        {{ $m }} month{{ $m === 1 ? '' : 's' }}
                                    </option>
                                @endfor
                            </select>
                            @error('access_duration_months')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 mt-1">How long a student keeps access after their payment is confirmed. Max {{ \App\Models\Course::MAX_ACCESS_DURATION_MONTHS }} months.</p>
                        </div>

                        <div class="flex items-end pb-1">
                            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                                <input type="checkbox" name="has_certificate" value="1"
                                    {{ old('has_certificate', $course->has_certificate ?? false) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                This course awards a certificate on completion
                            </label>
                        </div>

                        <div class="md:col-span-2 flex items-start pb-1">
                            <label class="flex items-start gap-2 text-sm font-semibold text-gray-700">
                                <input type="checkbox" name="requires_registration" value="1"
                                    {{ old('requires_registration', $course->requires_registration ?? false) ? 'checked' : '' }}
                                    class="mt-0.5 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <span>
                                    Require registration before purchase
                                    <span class="block text-xs text-gray-400 font-normal mt-0.5">Students must fill a short professional-details form for this course before "Buy" becomes available to them.</span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Weeks & resources --}}
                <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Course Content</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Weeks and their YouTube-link resources. Add as many of each as you like.</p>
                        </div>
                        <button type="button" @click="addWeek()"
                            class="text-sm font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-2 rounded-lg transition flex-shrink-0">
                            + Add Week
                        </button>
                    </div>

                    @if($errors->hasAny(collect($errors->keys())->filter(fn ($key) => str_starts_with($key, 'weeks.'))->all()))
                        <div class="bg-red-50 border border-red-200 rounded-xl p-3 mb-4 text-xs text-red-700 space-y-1">
                            @foreach($errors->keys() as $key)
                                @if(str_starts_with($key, 'weeks.'))
                                    <p>{{ $errors->first($key) }}</p>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                        <template x-for="(week, wIndex) in weeks" :key="wIndex">
                            <div class="border border-gray-200 rounded-xl p-4 self-start">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm font-bold text-gray-800" x-text="'WEEK ' + (wIndex + 1)"></span>
                                    <button type="button" @click="removeWeek(wIndex)" class="text-red-500 hover:text-red-700 text-xs font-semibold">
                                        Remove Week
                                    </button>
                                </div>

                                <input type="text" :name="`weeks[${wIndex}][title]`" x-model="week.title"
                                    :placeholder="'WEEK ' + (wIndex + 1) + ' title (optional)'"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-2 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">

                                <textarea :name="`weeks[${wIndex}][details]`" x-model="week.details" rows="2"
                                    placeholder="Brief details of what this week covers (optional, shown to students)"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-3 focus:ring-2 focus:ring-emerald-500 focus:border-transparent"></textarea>

                                <div class="space-y-2">
                                    <template x-for="(resource, rIndex) in week.resources" :key="rIndex">
                                        <div class="flex gap-2 items-center">
                                            <input type="text" :name="`weeks[${wIndex}][resources][${rIndex}][title]`" x-model="resource.title"
                                                placeholder="Resource title"
                                                class="flex-1 min-w-0 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                            <input type="url" :name="`weeks[${wIndex}][resources][${rIndex}][youtube_url]`" x-model="resource.youtube_url"
                                                placeholder="https://youtube.com/..."
                                                class="flex-1 min-w-0 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                            <button type="button" @click="removeResource(wIndex, rIndex)" class="text-red-400 hover:text-red-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>

                                <button type="button" @click="addResource(wIndex)"
                                    class="mt-3 text-xs font-semibold text-gray-600 hover:text-emerald-700">
                                    + Add Resource
                                </button>
                            </div>
                        </template>
                    </div>

                    <p x-show="weeks.length === 0" class="text-sm text-gray-400 text-center py-8">No weeks added yet. Click "Add Week" to get started.</p>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-6">

                {{-- Publish --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 mb-4">
                        <input type="checkbox" name="is_published" value="1"
                            {{ old('is_published', $course->is_published ?? true) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        Published (visible on storefront)
                    </label>
                    <button type="submit" class="w-full py-3 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                        {{ $course ? 'Save Changes' : 'Create Course' }}
                    </button>
                </div>

                {{-- Course image --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200"
                     x-data="courseImagePreview({
                         initialSrc: @js($course?->course_image_path),
                         fit: @js(old('course_image_fit', $course->course_image_fit ?? 'cover')),
                     })">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Course Image</h3>

                    <div class="relative w-full h-40 rounded-lg border border-gray-200 overflow-hidden mb-3 bg-gray-50 flex items-center justify-center">
                        <img x-show="previewSrc" :src="previewSrc" x-cloak class="w-full h-full object-cover">
                        <span x-show="!previewSrc" class="text-xs text-gray-400">No image selected</span>
                    </div>

                    @if(!empty($course?->course_image_path))
                        <button type="submit" form="delete-course-image"
                            class="text-xs font-semibold text-red-500 hover:text-red-700 mb-3">
                            Remove image
                        </button>
                    @endif

                    <input type="file" name="course_image" id="courseImageInput" accept="image/*" @change="onFileChange($event)"
                        class="w-full text-xs text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-semibold file:text-xs">
                    <p class="text-xs text-gray-400 mt-1.5">Shown on the course card and course page. Max size: <strong>2MB</strong>.</p>
                    <p id="courseImageError" class="text-xs text-red-600 mt-1.5 hidden"></p>
                    @error('course_image')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                        <p class="text-xs text-amber-600 mt-1">Please reselect the image below — browsers don't allow a page to pre-fill file selections after a reload.</p>
                    @enderror

                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <label class="block text-xs font-semibold text-gray-700 mb-1">When a student clicks the image to view it larger</label>
                        <select name="course_image_fit" x-model="fit"
                            class="w-full max-w-[220px] px-2.5 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <option value="cover">Fill the frame (crop to fit)</option>
                            <option value="contain">Show full image (no crop)</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-1.5">Only affects the enlarged view. The small course card always shows a cropped preview.</p>

                        <div x-show="previewSrc" x-cloak class="mt-3">
                            <p class="text-xs text-gray-400 mb-1.5">Preview of the enlarged view:</p>
                            <div class="relative w-full rounded-lg overflow-hidden bg-gray-900" style="height: 220px;">
                                <img :src="previewSrc" class="w-full h-full" :style="`object-fit:${fit};`">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Course materials --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200" x-data="materialsForm()">
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Course Materials (PDFs)</h3>
                    <p class="text-xs text-gray-400 mb-3">Optional — attach a PDF to a specific week so it appears under that week's videos, or leave it general. Max size: <strong>4MB per file</strong>.</p>

                    @if($course && $course->materials->isNotEmpty())
                        <ul class="space-y-1.5 mb-3">
                            @foreach($course->materials as $material)
                                <li class="flex items-center justify-between gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5">
                                    <span class="min-w-0 flex-1">
                                        <a href="{{ $material->download_url }}" target="_blank" class="text-xs text-emerald-700 hover:underline truncate block">
                                            {{ $material->label }}.pdf
                                        </a>
                                        <span class="text-[11px] text-gray-400">{{ $material->week_number ? 'Week '.$material->week_number : 'General' }}</span>
                                    </span>
                                    <button type="submit" form="delete-material-{{ $material->id }}"
                                        class="text-red-400 hover:text-red-600 flex-shrink-0" title="Remove">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="space-y-2" @change="onFileChange($event)">
                        <template x-for="rowId in rows" :key="rowId">
                            <div class="flex items-center gap-2">
                                <input type="file" :name="`materials[${rowId}]`" accept="application/pdf"
                                    class="material-file-input w-full text-xs text-gray-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-emerald-50 file:text-emerald-700 file:font-semibold file:text-xs">
                                <select :name="`material_weeks[${rowId}]`"
                                    class="flex-shrink-0 px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="">General</option>
                                    <template x-for="(week, wIndex) in weeks" :key="wIndex">
                                        <option :value="wIndex + 1" x-text="'Week ' + (wIndex + 1)"></option>
                                    </template>
                                </select>
                                <button type="button" @click="removeRow(rowId)" x-show="rows.length > 1"
                                    class="text-red-400 hover:text-red-600 flex-shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>

                    <button type="button" @click="addRow()" class="mt-2 text-xs font-semibold text-gray-600 hover:text-emerald-700">
                        + Add Another PDF
                    </button>

                    <p class="materials-error text-xs text-red-600 mt-2 hidden"></p>

                    @if($errors->hasAny(collect($errors->keys())->filter(fn ($key) => str_starts_with($key, 'materials'))->all()))
                        <div class="mt-2 space-y-1">
                            @foreach($errors->keys() as $key)
                                @if(str_starts_with($key, 'materials'))
                                    <p class="text-xs text-red-600">{{ $errors->first($key) }}</p>
                                @endif
                            @endforeach
                            <p class="text-xs text-amber-600">Please reselect the file(s) below — browsers don't allow a page to pre-fill file selections after a reload.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>

    @if($course)
        {{-- Danger zone: deliberately separate from the form above --}}
        <div class="mt-8 bg-red-50 border border-red-200 rounded-2xl p-5">
            <h3 class="text-sm font-bold text-red-800 mb-1">Danger Zone</h3>
            <p class="text-xs text-red-600 mb-3">
                Deleting this course removes it and all of its weeks, resources, materials, orders and reviews permanently. This cannot be undone.
            </p>
            <button type="submit" form="delete-course"
                class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition">
                Delete This Course Entirely
            </button>
        </div>

        {{-- Standalone delete forms, kept outside the main form above --}}
        <form id="delete-course" method="POST" action="{{ route('admin.courses.destroy', $course) }}"
              onsubmit="return confirm('Delete &quot;{{ $course->title }}&quot; entirely? This cannot be undone.');" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        @if($course->course_image_path)
            <form id="delete-course-image" method="POST" action="{{ route('admin.courses.course-image.destroy', $course) }}"
                  onsubmit="return confirm('Remove the course image?');" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endif

        @foreach($course->materials as $material)
            <form id="delete-material-{{ $material->id }}" method="POST" action="{{ route('admin.courses.materials.destroy', [$course, $material]) }}"
                  onsubmit="return confirm('Remove this file?');" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif
</div>

<script>
    function courseForm({ weeks }) {
        return {
            weeks: weeks || [],
            addWeek() {
                this.weeks.push({ title: '', details: '', resources: [] });
            },
            removeWeek(index) {
                this.weeks.splice(index, 1);
            },
            addResource(weekIndex) {
                this.weeks[weekIndex].resources.push({ title: '', youtube_url: '' });
            },
            removeResource(weekIndex, resourceIndex) {
                this.weeks[weekIndex].resources.splice(resourceIndex, 1);
            },
        };
    }

    function checkCombinedUploadSize(event) {
        const form = event.target;
        const maxMB = 7;
        let totalBytes = 0;

        const courseImageInput = form.querySelector('#courseImageInput');
        if (courseImageInput?.files[0]) {
            totalBytes += courseImageInput.files[0].size;
        }
        form.querySelectorAll('.material-file-input').forEach((input) => {
            if (input.files[0]) {
                totalBytes += input.files[0].size;
            }
        });

        const errorEl = document.getElementById('combinedUploadError');
        if (totalBytes > maxMB * 1024 * 1024) {
            errorEl.textContent = `The course image and PDF materials add up to ${(totalBytes / (1024 * 1024)).toFixed(1)}MB, over the ${maxMB}MB combined limit per save. Save the image and materials in separate steps.`;
            errorEl.classList.remove('hidden');
            errorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }

        errorEl.classList.add('hidden');
        return true;
    }

    function courseImagePreview({ initialSrc, fit }) {
        return {
            previewSrc: initialSrc || null,
            fit: fit || 'cover',
            onFileChange(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => { this.previewSrc = e.target.result; };
                reader.readAsDataURL(file);
            },
        };
    }

    function materialsForm() {
        return {
            rows: [1],
            nextId: 2,
            addRow() {
                this.rows.push(this.nextId++);
            },
            removeRow(rowId) {
                this.rows = this.rows.filter(id => id !== rowId);
            },
            onFileChange(event) {
                const input = event.target;
                if (!input.classList.contains('material-file-input')) return;

                const maxMB = 4;
                const file = input.files[0];
                const errorEl = this.$el.querySelector('.materials-error');

                if (file && file.size > maxMB * 1024 * 1024) {
                    errorEl.textContent = `"${file.name}" is ${(file.size / (1024 * 1024)).toFixed(1)}MB, which is over the ${maxMB}MB limit. Please choose a smaller file.`;
                    errorEl.classList.remove('hidden');
                    input.value = '';
                } else {
                    errorEl.classList.add('hidden');
                }
            },
        };
    }

    document.addEventListener('DOMContentLoaded', () => {
        const courseImageInput = document.getElementById('courseImageInput');
        const courseImageError = document.getElementById('courseImageError');
        const courseImageMaxMB = 2;

        courseImageInput?.addEventListener('change', () => {
            const file = courseImageInput.files[0];
            if (file && file.size > courseImageMaxMB * 1024 * 1024) {
                courseImageError.textContent = `"${file.name}" is ${(file.size / (1024 * 1024)).toFixed(1)}MB, which is over the ${courseImageMaxMB}MB limit. Please choose a smaller image.`;
                courseImageError.classList.remove('hidden');
                courseImageInput.value = '';
            } else {
                courseImageError.classList.add('hidden');
            }
        });
    });
</script>
@endsection
