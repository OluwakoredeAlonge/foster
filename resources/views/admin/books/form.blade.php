@extends('layouts.admin')

@section('title', $book ? 'Edit Book' : 'Add Book')

@section('content')
<div class="flex-1 max-w-2xl">
    <a href="{{ route('admin.books.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Books
    </a>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-5">{{ $book ? 'Edit Book' : 'Add Book' }}</h2>

        <form method="POST" action="{{ $book ? route('admin.books.update', $book) : route('admin.books.store') }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @if($book) @method('PUT') @endif

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Title</label>
                    <input type="text" name="title" required value="{{ old('title', $book->title ?? '') }}"
                        class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('title') border-red-400 @else border-gray-300 @enderror">
                    @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Category</label>
                    <input type="text" name="category" value="{{ old('category', $book->category ?? '') }}" placeholder="e.g. Addiction Recovery"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Blurb</label>
                <textarea name="blurb" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('blurb', $book->blurb ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Where to Buy / View Link</label>
                <input type="url" name="link_url" value="{{ old('link_url', $book->link_url ?? '') }}" placeholder="https://..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('link_url') border-red-400 @else border-gray-300 @enderror">
                @error('link_url') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">Where the "View Book" button sends visitors — an Amazon, Selar or Google Books link. Leave blank to hide the button.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Cover Image</label>
                @if($book && $book->cover_image_path)
                    <img src="{{ $book->cover_image_path }}" class="w-20 h-28 object-cover rounded-lg border border-gray-200 mb-2">
                @endif
                <input type="file" name="cover_image" accept="image/jpeg,image/png,image/webp"
                    class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-emerald-50 file:text-emerald-700 file:text-sm file:font-semibold hover:file:bg-emerald-100">
                @error('cover_image') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-gray-400 mt-1">Max size: 2MB. {{ $book ? 'Leave blank to keep the current cover.' : '' }}</p>
            </div>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $book->is_visible ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <span class="text-sm text-gray-700">Show on the public site</span>
            </label>

            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                {{ $book ? 'Save Changes' : 'Add Book' }}
            </button>
        </form>
    </div>
</div>
@endsection
