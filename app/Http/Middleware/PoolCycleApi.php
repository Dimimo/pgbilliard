<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

class PoolCycleApi
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('season') || $request->session()->has('cycle')) {
            $cycle = $request->header('season') ?: $request->session()->has('cycle');
            $season = DB::table('seasons')
                ->where('cycle', $cycle)
                ->orderBy('cycle', 'desc')
                ->firstOrFail();
        } else {
            // probably first visit
            $season = DB::table('seasons')->orderBy('cycle', 'desc')->first();
            //what if the DB is empty?
            if (is_null($season)) {
                Context::addHidden(['cycle', 'season_id']);
                $request->session()->forget(['cycle', 'season_id']);

                return $next($request);
            }
        }

        // set the hidden context
        $request->session()->put([
            'cycle' => $season->cycle,
            'season_id' => $season->id
        ]);
        Context::addHidden([
            'cycle' => $season->cycle,
            'season_id' => $season->id
        ]);

        return $next($request);
    }
}
