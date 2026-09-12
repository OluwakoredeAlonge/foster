@extends('layouts.admin')

@section('title', $testimonial ? 'Edit Testimonial' : 'Add Testimonial')

@section('content')
<div class="flex-1 max-w-2xl">
    <a href="{{ route('admin.testimonials.index') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-800 flex items-center gap-1.5 mb-6">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
        Back to Testimonials
    </a>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
        <h2 class="text-xl font-bold text-gray-900 mb-5">{{ $testimonial ? 'Edit Testimonial' : 'Add Testimonial' }}</h2>

        <form method="POST" action="{{ $testimonial ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" class="space-y-4">
            @csrf
            @if($testimonial) @method('PUT') @endif

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Client Name</label>
                    <input type="text" name="client_name" required value="{{ old('client_name', $testimonial->client_name ?? '') }}"
                        class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('client_name') border-red-400 @else border-gray-300 @enderror">
                    @error('client_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Client Role / Label</label>
                    <input type="text" name="client_role" value="{{ old('client_role', $testimonial->client_role ?? '') }}" placeholder="e.g. Addiction Recovery Client"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Quote</label>
                <textarea name="quote" rows="4" required
                    class="w-full px-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('quote') border-red-400 @else border-gray-300 @enderror">{{ old('quote', $testimonial->quote ?? '') }}</textarea>
                @error('quote') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Rating</label>
                <select name="rating" class="w-full sm:w-40 px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ (string) old('rating', $testimonial->rating ?? 5) === (string) $i ? 'selected' : '' }}>
                            {{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }}
                        </option>
                    @endfor
                </select>
            </div>

            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_visible" value="1" {{ old('is_visible', $testimonial->is_visible ?? true) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <span class="text-sm text-gray-700">Show on the public site</span>
            </label>

            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition">
                {{ $testimonial ? 'Save Changes' : 'Add Testimonial' }}
            </button>
        </form>
    </div>
</div>
@endsection
