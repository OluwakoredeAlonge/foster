@extends('layouts.admin')

@section('title', $service ? 'Edit Service' : 'Add Service')

@section('content')
<div class="flex-1 max-w-2xl">
    <a href="{{ route('admin.services.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Services
    </a>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-5">{{ $service ? 'Edit Service' : 'Add Service' }}</h2>

        <form method="POST" action="{{ $service ? route('admin.services.update', $service) : route('admin.services.store') }}" class="space-y-4">
            @csrf
            @if($service) @method('PUT') @endif

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Title</label>
                <input type="text" name="title" required value="{{ old('title', $service->title ?? '') }}"
                    class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('title') border-red-400 @else border-gray-300 @enderror">
                @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('description', $service->description ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Icon</label>
                <input type="text" name="icon" value="{{ old('icon', $service->icon ?? 'heart-handshake') }}" placeholder="e.g. heart-handshake"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent font-mono text-sm">
                <p class="text-xs text-gray-400 mt-1">Any icon name from <a href="https://lucide.dev/icons" target="_blank" class="underline hover:text-emerald-700">lucide.dev/icons</a>.</p>
            </div>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $service->is_visible ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <span class="text-sm text-gray-700">Show on the public site</span>
            </label>

            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                {{ $service ? 'Save Changes' : 'Add Service' }}
            </button>
        </form>
    </div>
</div>
@endsection
