<?php

namespace Tests\Models;

use App\Models\Event;
use App\Models\Game;
use App\Models\Player;
use App\Models\Schedule;

use function PHPUnit\Framework\{assertEquals, assertNull, assertTrue};

beforeEach(function () {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    Schedule::factory()->create();
    $this->schedule = Schedule::query()->find(1);
    $this->event = Event::query()->with('team_1.players')->find(1);

    Game::create([
        'schedule_id' => $this->schedule->id,
        'event_id' => $this->event->id,
        'team_id' => $this->event->team_1->id,
        'player_id' => $this->event->team_1->players()->first()->id,
        'user_id' => $this->event->team_1->players()->first()->user->id,
        'position' => 1,
        'home' => true,
        'win' => null,
    ]);

});

test('can create a game', function () {
    $game = Game::query()->first();
    $player = Player::query()->find(1);

    assertEquals($game->schedule, $this->schedule);
    assertEquals($game->player, $player);
    assertTrue($game->home);
    assertNull($game->win);
    assertEquals(Game::wherePlayerId($player->id)->first()->id, $game->id);
});

test('can update a game', function () {
    $game = Game::query()->first();
    assertNull($game->win);
    $game->update(['win' => true]);
    assertTrue($game->win);
});

test('can delete a game', function () {
    $games_count = Game::query()->count();
    assertEquals($games_count, 1);
    Game::query()->first()->delete();
    $games_count = Game::query()->count();
    assertEquals($games_count, 0);
});
