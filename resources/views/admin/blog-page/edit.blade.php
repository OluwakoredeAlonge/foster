@extends('layouts.admin')

@section('title', 'Blog Page')

@section('content')
<div class="flex-1 p-4 sm:p-6 max-w-2xl mx-auto">

    <div class="mb-6">
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Blog Page</h2>
        <p class="mt-1 text-sm text-gray-600">
            Edit the intro text on <a href="{{ route('blog.index') }}" target="_blank" class="text-emerald-700 hover:underline">/blog</a> and the "About Fosterheirs" card shown on every post. To write or edit the posts themselves, go to <a href="{{ route('admin.blog.index') }}" class="text-emerald-700 hover:underline">Blog</a> instead.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.blog-page.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 space-y-4">
            <h3 class="text-lg font-semibold text-gray-900">Page Intro</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Eyebrow</label>
                    <input type="text" name="eyebrow" value="{{ old('eyebrow', $settings->eyebrow) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Heading</label>
                    <input type="text" name="heading" value="{{ old('heading', $settings->heading) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Subheading</label>
                    <textarea name="subheading" rows="2"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">{{ old('subheading', $settings->subheading) }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">"No Articles Yet" Message</label>
                    <input type="text" name="empty_state_text" value="{{ old('empty_state_text', $settings->empty_state_text) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Shown only when there are no published posts to display.</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-2xl shadow-sm border border-gray-200 space-y-4">
            <h3 class="text-lg font-semibold text-gray-900">"About Fosterheirs" Card</h3>
            <p class="text-xs text-gray-500 -mt-3">Shown in the sidebar of every individual post.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Name</label>
                    <input type="text" name="author_name" value="{{ old('author_name', $settings->author_name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tagline</label>
                    <input type="text" name="author_tagline" value="{{ old('author_tagline', $settings->author_tagline) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Button Text</label>
                    <input type="text" name="author_cta_text" value="{{ old('author_cta_text', $settings->author_cta_text) }}"
                        class="w-full max-w-xs px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Links to the contact section on the homepage.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
