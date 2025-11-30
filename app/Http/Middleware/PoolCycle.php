<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

/**
 * Class PoolCycle
 */
class PoolCycle
{
    /**
     * Handle an incoming request.
     * If the session already has a cycle, load the Season model
     * If there is no session, check for an empty DB or load the most recent Season
     * Set the context and session, continue
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // if the session has a cycle, set the hidden context and continue
        if (session()->has(['cycle', 'season_id'])) {
            Context::addHidden([
                'cycle' => $request->session()->get('cycle'),
                'season_id' => $request->session()->get('season_id')

            ]);

            return $next($request);
        } else {
            // get the most recent season
            $season = \Illuminate\Support\Facades\DB::table('seasons')->orderBy('cycle', 'desc')->first();

            //what if the DB is empty?
            if (is_null($season)) {
                Context::addHidden(['cycle', 'season_id']);
                $request->session()->forget(['cycle', 'season_id']);

                return $next($request);
            }
        }

        // most probably first time visit, set the most recent season
        // either way, set the hidden context
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
