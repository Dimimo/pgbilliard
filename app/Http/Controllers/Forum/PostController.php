<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        return Post::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'is_locked' => ['boolean'],
            'is_sticky' => ['boolean'],
        ]);

        return Post::create($data);
    }

    public function show(Post $post)
    {
        $this->authorize('view', $post);

        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validate([
            'title' => ['required'],
            'slug' => ['required'],
            'body' => ['required'],
            'user_id' => ['required', 'integer'],
            'is_locked' => ['boolean'],
            'is_sticky' => ['boolean'],
        ]);
        $post->update($data);

        return $post;
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json();
    }
}
