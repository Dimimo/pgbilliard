<?php

use App\Livewire\Dashboard;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->member = \App\Models\User::factory()->create();
    $this->season = \App\Models\Season::factory()->create(['cycle' => now()->format('Y/m')]);
    session()->put('cycle', $this->season->cycle);
});

it('renders successfully', function (): void {
    Livewire::actingAs($this->member)
        ->test(Dashboard::class)
        ->assertStatus(200);
});

it('shows the correct component', function (): void {
    $this->actingAs($this->member);
    $response = $this->get('/dashboard');

    $response
        ->assertSeeVolt('dashboard')
        ->assertOk();
});

it('is a player without a team', function (): void {
    $this->actingAs($this->member);
    $response = $this->get('/dashboard');

    $response
        ->assertSee('What is your role in the current Season ' . $this->season->cycle)
        ->assertSee("You don't play for a team")
        ->assertOk();
});

it('is a player for a team and is not a captain', function (): void {
    $team = \App\Models\Team::factory()->create(['season_id' => $this->season->id]);
    \App\Models\Player::factory()
        ->create([
            'user_id' => $this->member->id,
            'team_id' => $team->id,
            'active' => true,
            'captain' => false,
        ]);
    $this->actingAs($this->member);
    $response = $this->get('/dashboard');

    $response
        ->assertSee('You play for')
        ->assertSee($team->name)
        ->assertDontSee('You are the Captain');
});

it('is a player for a team and is a captain', function (): void {
    $team = \App\Models\Team::factory()->create(['season_id' => $this->season->id]);
    \App\Models\Player::factory()
        ->create([
            'user_id' => $this->member->id,
            'team_id' => $team->id,
            'active' => true,
            'captain' => true,
        ]);
    $this->actingAs($this->member);
    $response = $this->get('/dashboard');

    $response
        ->assertSee('You are the Captain')
        ->assertSee('Your team members are:');
});
