@extends('layouts.admin')

@section('title', 'Our Therapists')

@section('content')
<div class="flex-1">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Our Therapists</h2>
            <p class="mt-1 text-sm text-gray-600">Manage who appears in the homepage "Meet the Team" section.</p>
        </div>
        <a href="{{ route('admin.team-members.create') }}"
            class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 text-sm font-semibold">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Team Member
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Name</th>
                    <th class="text-left px-5 py-3">Title</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($members as $member)
                    <tr class="hover:bg-gray-50 align-top">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-slate-400 to-slate-600 text-white text-xs font-bold flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    @if($member->photo_url)
                                        <img src="{{ $member->photo_url }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $member->initials() }}
                                    @endif
                                </div>
                                <span class="font-semibold text-gray-900">{{ $member->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $member->title }}</td>
                        <td class="px-5 py-3">
                            <div class="flex flex-wrap gap-1.5">
                                @if($member->is_visible)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Shown</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">Hidden</span>
                                @endif
                                @if($member->is_placeholder)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">Placeholder</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.team-members.toggle', $member) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold {{ $member->is_visible ? 'text-gray-500 hover:text-gray-800' : 'text-emerald-700 hover:text-emerald-900' }} mr-3">
                                    {{ $member->is_visible ? 'Hide' : 'Show' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.team-members.edit', $member) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-3">Edit</a>
                            <form method="POST" action="{{ route('admin.team-members.destroy', $member) }}" class="inline"
                                  onsubmit="return confirm('Remove &quot;{{ $member->name }}&quot;?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-gray-400">
                            No team members yet. <a href="{{ route('admin.team-members.create') }}" class="text-emerald-600 font-semibold hover:underline">Add one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
