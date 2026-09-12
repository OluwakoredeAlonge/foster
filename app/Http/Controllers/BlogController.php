<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $featuredPost = BlogPost::published()->where('featured', true)->latest('published_at')->first();

        $query = BlogPost::published()->where('featured', false);

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        $posts = $query->latest('published_at')->paginate(9)->withQueryString();
        $categories = BlogPost::published()->distinct()->pluck('category')->filter()->values();

        return view('blog.index', compact('featuredPost', 'posts', 'categories'));
    }

    public function show(BlogPost $post): View
    {
        abort_unless($post->status === 'published', 404);

        $post->increment('views');

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        $comments = $post->comments()->visible()->latest()->paginate(20);

        return view('blog.show', compact('post', 'related', 'comments'));
    }
}
