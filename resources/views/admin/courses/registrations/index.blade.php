@extends('layouts.admin')

@section('title', 'Course Registrations')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-6xl mx-auto">

    <div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Course Registrations</h2>
            <p class="mt-1 text-sm text-gray-600">Professional details submitted before purchase, for courses that require registration.</p>
        </div>
        <form method="GET" action="{{ route('admin.courses.registrations.index') }}" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Search course, student, profession..."
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
                    <th class="text-left px-5 py-3">Profession</th>
                    <th class="text-left px-5 py-3">Workplace</th>
                    <th class="text-left px-5 py-3">Qualification</th>
                    <th class="text-left px-5 py-3">Experience</th>
                    <th class="text-left px-5 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($registrations as $registration)
                    <tr class="hover:bg-gray-50 align-top">
                        <td class="px-5 py-3">
                            @if($registration->course)
                                <a href="{{ route('courses.show', $registration->course) }}" target="_blank" class="font-semibold text-gray-900 hover:text-emerald-700 hover:underline">
                                    {{ $registration->course->title }}
                                </a>
                            @else
                                <span class="text-gray-400">Deleted course</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-700">
                            {{ $registration->user->name ?? 'Unknown' }}
                            <p class="text-xs text-gray-400">{{ $registration->user->email ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3 text-gray-700">{{ $registration->profession }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $registration->workplace }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $registration->qualification }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $registration->years_of_experience }} yr{{ $registration->years_of_experience === 1 ? '' : 's' }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $registration->created_at->format('M j, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-gray-400">No registrations yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
</div>
@endsection
