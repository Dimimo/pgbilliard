<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;

class PoolCycleApi
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('season')) {
            $cycle = $request->header('season');
            $season = DB::table('seasons')
                ->where('cycle', $cycle)
                ->orderBy('cycle', 'desc')
                ->firstOrFail();
            session()->put('cycle', $season->cycle);

            return $next($request);
        }
        $recent_season = DB::table('seasons')->orderBy('cycle', 'desc')->first();
        $cycle = $recent_season ? $recent_season->cycle : '0000/00';
        session()->put('cycle', $cycle);

        return $next($request);
    }
}
