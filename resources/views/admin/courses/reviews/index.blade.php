@extends('layouts.admin')

@section('title', 'Course Comments & Reviews')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-6xl mx-auto">

    <div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Comments & Reviews</h2>
            <p class="mt-1 text-sm text-gray-600">What students have dropped on courses, across the whole catalogue.</p>
        </div>
        <form method="GET" action="{{ route('admin.courses.reviews.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search course, student, or comment..."
                class="px-3 py-2 border border-gray-300 rounded-lg text-sm w-64 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            <button type="submit" class="px-3 py-2 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-800 transition">Search</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Course</th>
                    <th class="text-left px-5 py-3">Student</th>
                    <th class="text-left px-5 py-3">Rating</th>
                    <th class="text-left px-5 py-3">Comment</th>
                    <th class="text-left px-5 py-3">Date</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50 align-top">
                        <td class="px-5 py-3">
                            @if($review->course)
                                <a href="{{ route('courses.show', $review->course) }}" target="_blank" class="font-semibold text-gray-900 hover:text-emerald-700 hover:underline">
                                    {{ $review->course->title }}
                                </a>
                            @else
                                <span class="text-gray-400">Deleted course</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-700">
                            {{ $review->user->name ?? 'Unknown' }}
                            <p class="text-xs text-gray-400">{{ $review->user->email ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-0.5 text-amber-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'fill-current' : '' }}"></i>
                                @endfor
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-700 max-w-xs">
                            {{ $review->comment ?: '—' }}
                        </td>
                        <td class="px-5 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $review->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('admin.courses.reviews.destroy', $review) }}" class="inline"
                                  onsubmit="return confirm('Remove this comment? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400">No comments yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
