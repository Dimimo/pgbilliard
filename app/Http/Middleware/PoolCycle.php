<?php
/**
 *  Copyright (c) 2016-2021 Puerto Parrot. Written by Dimitri Mostrey for https// www.puertoparrot.com
 *  Contact me at admin@puertoparrot.com or dmostrey@yahoo.com
 */

namespace App\Http\Middleware;

use App\Models\Date;
use Closure;
use DB;
use Illuminate\Http\Request;

/**
 * Class PoolCycle
 */
class PoolCycle
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->session()->exists('cycle') || empty($request->session()->get('cycle'))) {
            //when no cycle is in the session, put the most recent date cycle as a starting point
            $recent_season = DB::connection('mysql')->table('seasons')->orderBy('cycle', 'desc')->first();
            /** @var Date $recent_season */
            $season = $recent_season ? $recent_season->cycle : '0000/00';
            $request->session()->put('cycle', $season);
        }

        return $next($request);
    }
}
