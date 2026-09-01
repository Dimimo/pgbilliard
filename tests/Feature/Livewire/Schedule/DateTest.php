<?php

use App\Models\Game;
use App\Services\ScheduleManager;
use Illuminate\Support\Facades\Context;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $season = \App\Models\Season::query()->first();
    Context::addHidden([
        'cycle' => $season->cycle,
        'season_id' => $season->id
    ]);
    $this->player = \App\Models\Player::with('user')->find(1);
});

it('if a day schedule can be loaded but not edited', function (): void {
    $response = $this->get('/schedule/event/1');
    $response
        ->assertOk()
        ->assertSeeVolt('date.schedule')
        ->assertSee('team 1 - team 2')
        ->assertDontSee('Format 1')
        ->assertDontSee('Choose a day games format');
});

it('checks if the schedule can be selected, admin login to bypass the time test', function (): void {
    $event = \App\Models\Event::query()->find(1);
    $event->update(['confirmed' => false]);

    $admin = \App\Models\User::factory()->create(['name' => 'admin']);
    \App\Models\Admin::factory()->create(['user_id' => $admin->id]);
    session(['is_admin' => true]);

    $format1 = \App\Models\Format::factory()->create([
        'name' => 'Format 1',
        'details' => 'The format 1 details',
        'user_id' => $admin->id
    ]);
    $format2 = \App\Models\Format::factory()->create([
        'name' => 'Format 2',
        'details' => 'The format 2 details',
        'user_id' => $admin->id
    ]);

    \App\Models\Schedule::factory()->count(15)->create(['format_id' => $format1->id]);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Date\Schedule::class, ['event' => $event])
        ->assertViewIs('livewire.date.schedule')
        ->assertViewHas('switches.chooseFormat', true)
        ->assertViewHas('switches.confirmed', false)
        ->assertSee('Choose a day games format')
        ->assertSee($format1->name)
        ->assertSee($format2->details)
        ->call('formatChosen', $format1->id)
        ->assertViewHas('switches.chooseFormat', false)
        ->assertViewHas('format', $format1)
        ->assertDontSee('Choose a day games format')
        ->assertSee('The format used is the')
        ->assertSee('Home Team')
        ->assertSee('Visit Team');
});

it('checks if the players can be selected for the matrix overview', function (): void {
    $event = \App\Models\Event::query()->find(1);
    $format1 = \App\Models\Format::factory()->create([
        'name' => 'Format 1',
        'details' => 'The format 1 details',
        'user_id' => $this->player->user->id
    ]);

    \App\Models\Schedule::factory()->count(15)->create(['format_id' => $format1->id]);
    Game::factory()->count(15)->create();
    $event->update(['confirmed' => false]);
    $admin = \App\Models\User::factory()->create(['name' => 'admin']);
    \App\Models\Admin::factory()->create(['user_id' => $admin->id]);
    session(['is_admin' => true]);

    $team1_players = $event
        ->team_1
        ->activePlayers()
        ->sortBy('name');
    $team2_players = $event
        ->team_2
        ->activePlayers()
        ->sortBy('name');

    $switches = collect([
        'confirmed' => false,
        'canUpdatePlayers' => true,
        'chooseFormat' => false,
        'rounds' => [1 => 'First', 6 => 'Second', 11 => 'Last'],
        'games' => null,
    ]);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Date\SchedulePlayerSelector::class, ['event' => $event, 'switches' => $switches])
        ->assertCount('home_players', 4)
        ->assertCount('visit_players', 4)
        ->assertCount('home_matrix', 0)
        ->assertCount('visit_matrix', 0)
        ->call('playerSelected', $team1_players->shift()->id, 1, 'home')
        ->assertCount('home_matrix', 1)
        ->assertCount('visit_matrix', 0)
        ->call('playerSelected', $team2_players->shift()->id, 1, 'visit')
        ->assertCount('visit_matrix', 1)
        ->call('playerSelected', $team1_players->shift()->id, 2, 'home')
        ->call('playerSelected', $team1_players->shift()->id, 3, 'home')
        ->call('playerSelected', $team1_players->shift()->id, 4, 'home')
        ->call('playerSelected', $team2_players->shift()->id, 2, 'visit')
        ->call('playerSelected', $team2_players->shift()->id, 3, 'visit')
        ->call('playerSelected', $team2_players->shift()->id, 4, 'visit')
        ->assertCount('home_matrix', 4)
        ->assertCount('visit_matrix', 4)
        ->assertDispatched('player-selected');
});

it('applies a determined third double from a three-player format to the daily games', function (): void {
    $event = \App\Models\Event::query()->findOrFail(1);
    $event->update(['confirmed' => false]);
    $admin = \App\Models\User::factory()->create(['name' => 'admin']);
    \App\Models\Admin::factory()->create(['user_id' => $admin->id]);
    session(['is_admin' => true]);

    $format = \App\Models\Format::factory()->create([
        'name' => 'Three players',
        'players' => 3,
        'user_id' => $admin->id,
    ]);
    Livewire::test(\App\Livewire\Admin\Schedule\Create::class, ['format' => $format]);

    foreach ([true, false] as $home) {
        $slots = $format->schedules()
            ->wherePosition(15)
            ->whereHome($home)
            ->orderBy('id')
            ->get();
        $slots->first()->update(['player' => 1]);
        $slots->last()->update(['player' => 2]);
    }

    (new ScheduleManager($event))->checkThirdGame($format);

    $switches = collect([
        'confirmed' => false,
        'canUpdatePlayers' => true,
        'chooseFormat' => false,
        'rounds' => [1 => 'First', 6 => 'Second', 11 => 'Last'],
        'games' => null,
    ]);
    $homePlayers = $event->team_1->activePlayers()->take(3)->values();
    $visitPlayers = $event->team_2->activePlayers()->take(3)->values();

    $component = Livewire::actingAs($admin)->test(
        \App\Livewire\Date\SchedulePlayerSelector::class,
        ['event' => $event, 'switches' => $switches],
    );

    foreach (range(1, 3) as $position) {
        $component
            ->call('playerSelected', $homePlayers[$position - 1]->id, $position, 'home')
            ->call('playerSelected', $visitPlayers[$position - 1]->id, $position, 'visit');
    }

    expect($event->games()->wherePosition(15)->count())->toBe(4)
        ->and($event->games()->wherePosition(15)->whereNotNull('player_id')->count())->toBe(4)
        ->and(
            $event->games()
                ->wherePosition(15)
                ->whereHas('schedule', fn ($query) => $query->wherePlayer(1))
                ->pluck('player_id')
                ->sort()
                ->values()
                ->all(),
        )->toBe(collect([$homePlayers[0]->id, $visitPlayers[0]->id])->sort()->values()->all());
});
