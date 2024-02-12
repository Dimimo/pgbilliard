<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Tag::class);

        return Tag::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);
        $data = $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
        ]);

        return Tag::create($data);
    }

    public function show(Tag $tag)
    {
        $this->authorize('view', $tag);

        return $tag;
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $data = $request->validate([
            'name' => ['required'],
            'slug' => ['required'],
        ]);
        $tag->update($data);

        return $tag;
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);
        $tag->delete();

        return response()->json();
    }
}
