<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Comment::class);

        return Comment::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Comment::class);
        $data = $request->validate([
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'post_id' => ['required', 'integer'],
        ]);

        return Comment::create($data);
    }

    public function show(Comment $comment)
    {
        $this->authorize('view', $comment);

        return $comment;
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $data = $request->validate([
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'post_id' => ['required', 'integer'],
        ]);
        $comment->update($data);

        return $comment;
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return response()->json();
    }
}
