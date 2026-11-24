<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        if (!rj_get_option('comments_enabled', true) || !$post->allow_comments) {
            abort(403, __('Comments are disabled for this post.'));
        }

        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|string|max:5000',
            'parent_id' => 'nullable|integer|exists:rj_comments,id',
            'author_url' => 'nullable|url|max:255',
        ]);

        $comment = new Comment([
            'post_id' => $post->id,
            'parent_id' => $validated['parent_id'] ?? null,
            'author_name' => $validated['author_name'],
            'author_email' => $validated['author_email'],
            'author_url' => $validated['author_url'] ?? null,
            'content' => $validated['content'],
        ]);

        $comment->author_ip = $request->ip();
        
        if (auth()->check()) {
            $comment->user_id = auth()->id();
        }

        $comment->status = 'pending'; // Şərhlər əvvəlcə təsdiq gözləyir

        $comment->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Your comment has been submitted and is awaiting moderation.'),
            ]);
        }

        return back()->with('success', __('Your comment has been submitted and is awaiting moderation.'));
    }
}