@extends('layouts.admin')

@section('title', $member ? 'Edit Team Member' : 'Add Team Member')

@section('content')
<div class="flex-1 max-w-2xl">
    <a href="{{ route('admin.team-members.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Our Therapists
    </a>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-5">{{ $member ? 'Edit Team Member' : 'Add Team Member' }}</h2>

        <form method="POST" action="{{ $member ? route('admin.team-members.update', $member) : route('admin.team-members.store') }}" class="space-y-4">
            @csrf
            @if($member) @method('PUT') @endif

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Name</label>
                    <input type="text" name="name" required value="{{ old('name', $member->name ?? '') }}"
                        class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name') border-red-400 @else border-gray-300 @enderror">
                    @error('name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Title / Role</label>
                    <input type="text" name="title" value="{{ old('title', $member->title ?? '') }}" placeholder="e.g. Licensed Marriage &amp; Family Therapist"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Bio</label>
                <textarea name="bio" rows="4"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('bio', $member->bio ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Photo URL</label>
                <input type="url" name="photo_url" value="{{ old('photo_url', $member->photo_url ?? '') }}" placeholder="https://..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <p class="text-xs text-gray-400 mt-1">Leave blank to show initials instead of a photo.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Tags</label>
                <input type="text" name="tags" value="{{ old('tags', isset($member) ? implode(', ', $member->tags ?? []) : '') }}" placeholder="e.g. Physician, Author"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                <p class="text-xs text-gray-400 mt-1">Comma-separated short badges shown under the bio.</p>
            </div>

            <div class="flex flex-col gap-2">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $member->is_visible ?? true) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Show on the public site</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_placeholder" value="1" {{ old('is_placeholder', $member->is_placeholder ?? false) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Show "Profile coming soon" instead of the bio</span>
                </label>
            </div>

            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                {{ $member ? 'Save Changes' : 'Add Team Member' }}
            </button>
        </form>
    </div>
</div>
@endsection
