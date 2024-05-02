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
        //what if there are no seasons, if the DB is empty?
        if (DB::table('seasons')->count() === 0) {
            return $next($request);
        }
        //if there are seasons but the most session value is empty, choose the most recent one
        if (! $request->session()->exists('cycle') || empty($request->session()->get('cycle')) || $request->session()->get('cycle') === '0000/00') {
            //when no cycle is in the session, put the most recent date cycle as a starting point
            $recent_season = DB::table('seasons')->orderBy('cycle', 'desc')->first();
            $season = $recent_season ? $recent_season['cycle'] : '0000/00';
            $request->session()->put('cycle', $season);
        }

        return $next($request);
    }
}
