@extends('layouts.admin')

@section('title', $resource ? 'Edit Resource' : 'Add Resource')

@section('content')
<div class="flex-1 max-w-2xl">
    <a href="{{ route('admin.site-resources.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Resources
    </a>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-5">{{ $resource ? 'Edit Resource' : 'Add Resource' }}</h2>

        <form method="POST" action="{{ $resource ? route('admin.site-resources.update', $resource) : route('admin.site-resources.store') }}" class="space-y-4">
            @csrf
            @if($resource) @method('PUT') @endif

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Title</label>
                    <input type="text" name="title" required value="{{ old('title', $resource->title ?? '') }}"
                        class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('title') border-red-400 @else border-gray-300 @enderror">
                    @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Category</label>
                    <input type="text" name="category" value="{{ old('category', $resource->category ?? '') }}" placeholder="e.g. Trauma Healing"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Blurb</label>
                <textarea name="blurb" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('blurb', $resource->blurb ?? '') }}</textarea>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Link URL</label>
                    <input type="url" name="url" value="{{ old('url', $resource->url ?? '') }}" placeholder="https://..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('url') border-red-400 @else border-gray-300 @enderror">
                    @error('url') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-1">Where the card links to — the full article or blog post.</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Read Time</label>
                    <input type="text" name="read_time" value="{{ old('read_time', $resource->read_time ?? '5 min read') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $resource->is_visible ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <span class="text-sm text-gray-700">Show on the public site</span>
            </label>

            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                {{ $resource ? 'Save Changes' : 'Add Resource' }}
            </button>
        </form>
    </div>
</div>
@endsection
