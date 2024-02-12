<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\Forum\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Visit::class);

        return Visit::all();
    }

    public function store(Request $request)
    {
        $this->authorize('create', Visit::class);
        $data = $request->validate([
            'user_id' => ['required', 'integer'],
            'post_id' => ['required', 'integer'],
        ]);

        return Visit::create($data);
    }

    public function show(Visit $visit)
    {
        $this->authorize('view', $visit);

        return $visit;
    }

    public function update(Request $request, Visit $visit)
    {
        $this->authorize('update', $visit);
        $data = $request->validate([
            'user_id' => ['required', 'integer'],
            'post_id' => ['required', 'integer'],
        ]);
        $visit->update($data);

        return $visit;
    }

    public function destroy(Visit $visit)
    {
        $this->authorize('delete', $visit);
        $visit->delete();

        return response()->json();
    }
}
