<?php

use App\Http\Resources\DatesResource;
use App\Http\Resources\EventGamesResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\TeamResource;
use App\Models\Date;
use App\Models\Event;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', fn (Request $request) => $request->user());

Route::get('user/{id}', fn (string $id) => new \App\Http\Resources\UserResource(\App\Models\User::query()->findOrFail($id)));
Route::get('date/{date}', fn (Date $date) => new DatesResource($date))
    ->middleware('season.visible:date,season');
Route::get('player/{player}', fn (Player $player) => new PlayerResource($player->load('team')))
    ->middleware('season.visible:player,team.season');
Route::get('team/{team}', fn (Team $team) => new TeamResource($team->load('venue')))
    ->middleware('season.visible:team,season');
Route::get(
    'event/{event}',
    fn (Event $event) => new EventResource($event->load(['date', 'venue', 'team_1', 'team_2'])),
)->middleware('season.visible:event,date.season');
Route::get(
    'schedule/event/{event}',
    fn (Event $event) => new EventGamesResource($event->load([
        'date',
        'games' => fn (\Illuminate\Database\Eloquent\Relations\HasMany $query) => $query
            ->with('player')
            ->orderBy('position')
            ->orderByDesc('home'),
    ])),
)->middleware('season.visible:event,date.season');
