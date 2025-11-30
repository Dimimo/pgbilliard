<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());

Route::get('user/{id}', fn (string $id) => new \App\Http\Resources\UserResource(\App\Models\User::query()->findOrFail($id)));
Route::get('date/{id}', fn (string $id) => new \App\Http\Resources\DatesResource(\App\Models\Date::query()->findOrFail($id)));
Route::get('player/{id}', fn (string $id) => new \App\Http\Resources\PlayerResource(\App\Models\Player::query()->with('team')->findOrFail($id)));
Route::get('team/{id}', fn (string $id) => new \App\Http\Resources\TeamResource(\App\Models\Team::query()->with('venue')->findOrFail($id)));
Route::get('event/{id}', fn (string $id) => new \App\Http\Resources\EventResource(\App\Models\Event::query()->with(['date', 'venue', 'team_1', 'team_2'])->findOrFail($id)));
Route::get('schedule/event/{id}', fn (string $id) => new \App\Http\Resources\EventGamesResource(\App\Models\Event::query()->with(['date', 'games' => fn (\Illuminate\Database\Eloquent\Relations\HasMany $query) => $query->with('player')->orderBy('position')->orderByDesc('home')])->findOrFail($id)));
