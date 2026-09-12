<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Services\CloudinaryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::latest()->paginate(15);

        return view('admin.blog.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.blog.form', ['post' => null]);
    }

    public function store(Request $request, CloudinaryService $cloudinary): RedirectResponse
    {
        $data = $this->validatePost($request);

        $data['slug'] = BlogPost::where('title', $data['title'])->exists()
            ? Str::slug($data['title']).'-'.Str::random(4)
            : Str::slug($data['title']);
        $data['featured'] = $request->boolean('featured');
        $data['tags'] = $this->parseTags($request->input('tags'));
        $data['published_at'] = $data['status'] === 'published' ? ($data['published_at'] ?? now()) : null;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $cloudinary->upload($request->file('cover_image'), 'blog');
        }

        $post = BlogPost::create($data);

        return redirect()->route('admin.blog.edit', $post)->with('success', "\"{$post->title}\" created.");
    }

    public function edit(BlogPost $post): View
    {
        return view('admin.blog.form', compact('post'));
    }

    public function update(Request $request, BlogPost $post, CloudinaryService $cloudinary): RedirectResponse
    {
        $data = $this->validatePost($request);

        $data['featured'] = $request->boolean('featured');
        $data['tags'] = $this->parseTags($request->input('tags'));
        $data['published_at'] = $data['status'] === 'published' ? ($data['published_at'] ?? $post->published_at ?? now()) : null;

        if ($request->hasFile('cover_image')) {
            $cloudinary->delete($post->cover_image);
            $data['cover_image'] = $cloudinary->upload($request->file('cover_image'), 'blog');
        }

        if ($request->boolean('remove_cover_image')) {
            $cloudinary->delete($post->cover_image);
            $data['cover_image'] = null;
        }

        $post->update($data);

        return redirect()->route('admin.blog.edit', $post)->with('success', "\"{$post->title}\" updated.");
    }

    public function destroy(BlogPost $post, CloudinaryService $cloudinary): RedirectResponse
    {
        $cloudinary->delete($post->cover_image);
        $post->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Post deleted.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:draft,published'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'external_link' => ['nullable', 'url', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'read_time' => ['nullable', 'integer', 'min:1', 'max:120'],
            'tags' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function parseTags(?string $tags): ?array
    {
        if (! $tags) {
            return null;
        }

        $parsed = array_values(array_filter(array_map('trim', explode(',', $tags))));

        return $parsed ?: null;
    }
}
