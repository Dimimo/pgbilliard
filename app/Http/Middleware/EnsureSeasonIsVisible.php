<?php

namespace App\Http\Middleware;

use App\Models\Season;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class EnsureSeasonIsVisible
{
    public function handle(
        Request $request,
        Closure $next,
        string $routeParameter,
        string $seasonPath,
    ): Response {
        $season = data_get($request->route($routeParameter), $seasonPath);

        if (!$season instanceof Season || Gate::denies('view', $season)) {
            if ($request->is('api/*')) {
                abort(404);
            }

            return redirect()->route('scoreboard');
        }

        $this->setCurrentSeason($request, $season);

        return $next($request);
    }

    private function setCurrentSeason(Request $request, Season $season): void
    {
        if ($request->hasSession()) {
            if ((int) $request->session()->get('season_id') !== $season->id) {
                $request->session()->forget('my_team');
            }

            $request->session()->put([
                'cycle' => $season->cycle,
                'season_id' => $season->id,
            ]);
        }

        Context::addHidden([
            'cycle' => $season->cycle,
            'season_id' => $season->id,
        ]);
    }
}
