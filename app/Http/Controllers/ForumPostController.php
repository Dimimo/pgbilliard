<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;

class ForumPostController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ForumPost::class);

        return ForumPost::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', ForumPost::class);
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'is_locked' => ['boolean'],
            'is_sticky' => ['boolean'],
        ]);

        return ForumPost::create($data);
    }

    public function show(ForumPost $forumPost)
    {
        $this->authorize('view', $forumPost);

        return $forumPost;
    }

    public function update(Request $request, ForumPost $forumPost)
    {
        $this->authorize('update', $forumPost);
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'is_locked' => ['boolean'],
            'is_sticky' => ['boolean'],
        ]);
        $forumPost->update($data);

        return $forumPost;
    }

    public function destroy(ForumPost $forumPost)
    {
        $this->authorize('delete', $forumPost);
        $forumPost->delete();

        return response()->json();
    }
}
