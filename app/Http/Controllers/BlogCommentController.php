<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function store(Request $request, BlogPost $post)
    {
        // Honeypot — a real visitor never sees or fills this field, only bots do.
        if ($request->filled('website')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => true]);
            }

            return back()->with('success', 'Comment posted.')->withFragment('comments');
        }

        $data = $request->validate([
            'author_name' => ['nullable', 'string', 'max:80'],
            'body' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $comment = BlogComment::create([
            'blog_post_id' => $post->id,
            'author_name' => $data['author_name'] ?? null,
            'body' => $data['body'],
            'ip_address' => $request->ip(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'display_name' => $comment->display_name,
                    'initial' => strtoupper(substr($comment->display_name, 0, 1)),
                    'body' => $comment->body,
                    'created_at' => $comment->created_at->diffForHumans(),
                ],
            ]);
        }

        return back()->with('success', 'Comment posted.')->withFragment('comments');
    }
}
