<?php

namespace App\Http\Controllers;

use App\Models\ForumTag;
use Illuminate\Http\Request;

class ForumTagController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ForumTag::class);

        return ForumTag::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', ForumTag::class);
        $data = $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
        ]);

        return ForumTag::create($data);
    }

    public function show(ForumTag $forumTag)
    {
        $this->authorize('view', $forumTag);

        return $forumTag;
    }

    public function update(Request $request, ForumTag $forumTag)
    {
        $this->authorize('update', $forumTag);
        $data = $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
        ]);
        $forumTag->update($data);

        return $forumTag;
    }

    public function destroy(ForumTag $forumTag)
    {
        $this->authorize('delete', $forumTag);
        $forumTag->delete();

        return response()->json();
    }
}
