<?php

namespace App\Http\Middleware;

use App\Models\Date;
use App\Taps\Cycle;
use Closure;
use Illuminate\Http\Request;

class TeamOfLoggedInUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->session()->exists('my_team')) {
            if (!auth()->check()) {
                $request->session()->put('my_team');
            } elseif (empty($request->session()->get('my_team'))) {
                $date = Date::query()->tap(new Cycle())->orderBy('dates.date')->first();
                $team = $date->getTeam(auth()->user());
                $request->session()->put('my_team', $team?->id);
            }
        }
        return $next($request);
    }
}
