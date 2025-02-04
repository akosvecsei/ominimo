<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Store a comment on a post
    public function store(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['message' => 'Comment added successfully!', 'comment' => $comment]);
    }

    // Delete a comment
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id() && $comment->post->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully!']);
    }
}
