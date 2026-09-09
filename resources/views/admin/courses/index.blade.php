@extends('layouts.admin')

@section('title', 'Courses')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-7xl mx-auto">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Courses</h2>
            <p class="mt-1 text-sm text-gray-600">Manage courses shown on the public storefront</p>
        </div>
        <a href="{{ route('admin.courses.create') }}"
            class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 text-sm font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Course
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Course</th>
                    <th class="text-left px-5 py-3">Price</th>
                    <th class="text-left px-5 py-3">Weeks</th>
                    <th class="text-left px-5 py-3">Rating</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($courses as $course)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($course->course_image_path)
                                        <img src="{{ $course->course_image_path }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0121 17.657L12 22l-9-4.343a12.083 12.083 0 012.84-7.079L12 14z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900">{{ $course->title }}</span>
                                    @if($course->category)
                                        <p class="text-xs text-gray-400">{{ $course->category->name }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-700">
                            ₦{{ number_format($course->price, 0) }}
                            @if($course->original_price)
                                <span class="text-gray-400 line-through text-xs ml-1">₦{{ number_format($course->original_price, 0) }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $course->weeks_count }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ number_format($course->rating_avg, 1) }} ({{ $course->ratings_count }})</td>
                        <td class="px-5 py-3">
                            @if($course->is_published)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Published</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">Draft</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('courses.show', $course) }}" target="_blank" class="text-gray-500 hover:text-gray-800 mr-3 text-xs font-semibold">View</a>
                            <a href="{{ route('admin.courses.edit', $course) }}" class="text-blue-600 hover:text-blue-800 mr-3 text-xs font-semibold">Edit</a>
                            <form method="POST" action="{{ route('admin.courses.duplicate', $course) }}" class="inline"
                                  onsubmit="return confirm('Duplicate &quot;{{ $course->title }}&quot;? The copy is saved as a draft so you can review it before publishing.');">
                                @csrf
                                <button type="submit" class="text-emerald-700 hover:text-emerald-900 mr-3 text-xs font-semibold">Duplicate</button>
                            </form>
                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="inline"
                                  onsubmit="return confirm('Delete this course? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                            No courses yet. <a href="{{ route('admin.courses.create') }}" class="text-emerald-600 font-semibold hover:underline">Add your first course</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</div>
@endsection
