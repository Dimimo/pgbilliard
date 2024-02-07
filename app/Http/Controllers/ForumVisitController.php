<?php

namespace App\Http\Controllers;

use App\Models\ForumVisit;
use Illuminate\Http\Request;

class ForumVisitController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ForumVisit::class);

        return ForumVisit::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', ForumVisit::class);
        $data = $request->validate([
            'user_id' => ['required', 'integer'],
            'forum_post_id' => ['required', 'integer'],
        ]);

        return ForumVisit::create($data);
    }

    public function show(ForumVisit $forumVisit)
    {
        $this->authorize('view', $forumVisit);

        return $forumVisit;
    }

    public function update(Request $request, ForumVisit $forumVisit)
    {
        $this->authorize('update', $forumVisit);
        $data = $request->validate([
            'user_id' => ['required', 'integer'],
            'forum_post_id' => ['required', 'integer'],
        ]);
        $forumVisit->update($data);

        return $forumVisit;
    }

    public function destroy(ForumVisit $forumVisit)
    {
        $this->authorize('delete', $forumVisit);
        $forumVisit->delete();

        return response()->json();
    }
}
