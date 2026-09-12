@extends('layouts.admin')

@section('title', 'Blog')

@section('content')
<div class="flex-1">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Blog</h2>
            <p class="mt-1 text-sm text-gray-600">Write and manage articles shown at <a href="{{ route('blog.index') }}" target="_blank" class="text-emerald-700 hover:underline">/blog</a>.</p>
        </div>
        <a href="{{ route('admin.blog.create') }}"
            class="bg-emerald-600 text-white px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition flex items-center gap-2 text-sm font-semibold">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Write Post
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="text-left px-5 py-3">Post</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Views</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50 align-top">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden flex-shrink-0">
                                    @if($post->cover_image)
                                        <img src="{{ $post->cover_image }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-semibold text-gray-900">{{ $post->title }}</span>
                                    @if($post->featured)
                                        <span class="ml-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $post->category ?: '—' }}</td>
                        <td class="px-5 py-3">
                            @if($post->status === 'published')
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">Published</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">Draft</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ number_format($post->views) }}</td>
                        <td class="px-5 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.blog.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-3">Edit</a>
                            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" class="inline"
                                  onsubmit="return confirm('Delete this post? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-semibold">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            No posts yet. <a href="{{ route('admin.blog.create') }}" class="text-emerald-600 font-semibold hover:underline">Write your first one</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
      </div>
    </div>

    @if($posts->hasPages())
        <div class="mt-6">{{ $posts->onEachSide(1)->links() }}</div>
    @endif
</div>
@endsection
