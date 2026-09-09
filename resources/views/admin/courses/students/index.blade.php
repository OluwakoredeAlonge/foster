@extends('layouts.admin')

@section('title', 'Students')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-6xl mx-auto">

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Students</h2>
            <p class="mt-1 text-sm text-gray-600">Everyone registered on the course storefront.</p>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.courses.students.index') }}" class="mb-6 max-w-sm">
        <div class="relative">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10.5A6.5 6.5 0 114 10.5a6.5 6.5 0 0113 0z"/>
            </svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name or email"
                class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
    </form>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Student</th>
                    <th class="text-left px-5 py-3">Joined</th>
                    <th class="text-left px-5 py-3">Orders</th>
                    <th class="text-left px-5 py-3">Confirmed Courses</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3">
                            <span class="font-semibold text-gray-900">{{ $student->name }}</span>
                            <p class="text-xs text-gray-400">{{ $student->email }}</p>
                        </td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $student->created_at->format('M j, Y') }}</td>
                        <td class="px-5 py-3 text-gray-700">{{ $student->course_orders_count }}</td>
                        <td class="px-5 py-3">
                            @if($student->confirmed_orders_count > 0)
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">{{ $student->confirmed_orders_count }} confirmed</span>
                            @else
                                <span class="text-gray-400 text-xs">None yet</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.courses.students.show', $student) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            @if($search)
                                No students match "{{ $search }}".
                            @else
                                No students have registered yet.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $students->links() }}
    </div>
</div>
@endsection
