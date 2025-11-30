<?php

beforeEach(function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $this->player = \App\Models\Player::with('user')->find(1);
    $this->format = \App\Models\Format::factory()->create([
        'name' => 'Format 1',
        'details' => 'The format 1 details',
        'user_id' => $this->player->user->id
    ]);
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
    \App\Models\Format::factory()->create(['name' => 'Format 2', 'details' => 'The format 2 details', 'user_id' => $this->player->user->id]);
    $admin = \App\Models\User::factory()->create(['name' => 'admin']);
    \App\Models\Admin::factory()->create(['user_id' => $admin->id]);
    session(['is_admin' => true]);

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Date\Schedule::class, ['event' => $event])
        ->assertViewIs('livewire.date.schedule')
        ->assertViewHas('choose_format', true)
        ->assertSee('Choose a day games format')
        ->assertSee('Format 1')
        ->assertSee('The format 2 details')
        ->call('formatChosen', 1)
        ->assertViewHas('choose_format', false)
        ->assertViewHas('format', $this->format)
        ->assertDontSee('Choose a day games format')
        ->assertSee('The format used is the')
        ->assertSee('Home Team')
        ->assertSee('Visit Team');
});

it('checks if the players can be selected for the matrix overview', function (): void {
    $event = \App\Models\Event::query()->find(1);
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

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Date\Schedule::class, ['event' => $event])
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
        ->assertDispatched('refresh-list');
});
