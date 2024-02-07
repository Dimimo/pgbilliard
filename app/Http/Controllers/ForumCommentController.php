<?php

namespace App\Http\Controllers;

use App\Models\ForumComment;
use Illuminate\Http\Request;

class ForumCommentController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ForumComment::class);

        return ForumComment::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', ForumComment::class);
        $data = $request->validate([
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'forum_post_id' => ['required', 'integer'],
        ]);

        return ForumComment::create($data);
    }

    public function show(ForumComment $forumComment)
    {
        $this->authorize('view', $forumComment);

        return $forumComment;
    }

    public function update(Request $request, ForumComment $forumComment)
    {
        $this->authorize('update', $forumComment);
        $data = $request->validate([
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'forum_post_id' => ['required', 'integer'],
        ]);
        $forumComment->update($data);

        return $forumComment;
    }

    public function destroy(ForumComment $forumComment)
    {
        $this->authorize('delete', $forumComment);
        $forumComment->delete();

        return response()->json();
    }
}
