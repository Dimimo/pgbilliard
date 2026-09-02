<?php

namespace App\Http\Middleware;

use App\Models\Season;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;

/**
 * Class PoolCycle
 */
class PoolCycle
{
    /**
     * Keep the current season limited to seasons visible to the current user.
     * Fall back to their latest visible season when the stored selection is unavailable.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $season = Season::query()
            ->visibleTo($request->user())
            ->find($request->session()->get('season_id'));

        if (!$season) {
            $season = Season::query()
                ->visibleTo($request->user())
                ->orderByDesc('cycle')
                ->first();
        }

        if (!$season) {
            Context::addHidden([
                'cycle' => null,
                'season_id' => null,
            ]);
            $request->session()->forget(['cycle', 'season_id', 'my_team']);

            return $next($request);
        }

        if ((int) $request->session()->get('season_id') !== $season->id) {
            $request->session()->forget('my_team');
        }

        $request->session()->put([
            'cycle' => $season->cycle,
            'season_id' => $season->id,
        ]);
        Context::addHidden([
            'cycle' => $season->cycle,
            'season_id' => $season->id,
        ]);

        return $next($request);
    }
}
