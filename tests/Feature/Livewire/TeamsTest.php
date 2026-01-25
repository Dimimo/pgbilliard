<?php

use App\Livewire\Teams;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $this->team = \App\Models\Team::query()->find(1);
    $this->player = \App\Models\Player::factory()->create(['team_id' => $this->team->id, 'captain' => false]);
    $this->captain = \App\Models\Player::factory()->create(['team_id' => $this->team->id, 'captain' => true]);
    $this->owner = \App\Models\User::factory()->create();
    \App\Models\Venue::query()->find(1)->update(['user_id' => $this->owner->id]);
    $season = \App\Models\Season::query()->first();
    Context::addHidden([
        'cycle' => $season->cycle,
        'season_id' => $season->id,
    ]);
    session(['is_admin' => false]);
});

it('renders successfully', function (): void {
    Livewire::test(Teams::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.teams');
});

it('has teams', function (): void {
    Livewire::test(Teams::class)
        ->assertViewHas('teams')
        ->assertCount('teams', 2);
});

it('shows the team and venue name', function (): void {
    Livewire::test(Teams::class)
        ->assertSee($this->team->name)
        ->assertSee($this->team->venue->name);
});

it('does not show the phone numbers as a guest', function (): void {
    Livewire::test(Teams::class)
        ->assertSee('hidden');
});

it('shows the correct phone number if logged in but can not edit', function (): void {
    Livewire::actingAs($this->player->user)
        ->test(Teams::class)
        ->assertDontSee($this->team->venue->contact_nr)
        ->assertSee($this->captain->phone)
        ->assertDontSeeHtml('teams/edit')
        ->assertDontSeeHtml('venues/edit');
});

it('checks if the captain can edit the team', function (): void {
    Livewire::actingAs($this->captain->user)
        ->test(Teams::class)
        ->assertOk()
        ->assertSeeText($this->captain->user->contact_nr)
        ->assertSeeHtml('team/edit/1')
        ->assertDontSeeHtml('venues/edit');
});

it('checks if the bar owner can edit the venue and shows their contact number', function (): void {
    Livewire::actingAs($this->owner)
        ->test(Teams::class)
        ->assertOk()
        ->assertSeeHtml('venues/edit/1');
});
