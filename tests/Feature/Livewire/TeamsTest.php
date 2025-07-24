<?php

use App\Livewire\Teams;
use Livewire\Livewire;

beforeEach(function () {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $this->team = \App\Models\Team::find(1);
    $this->player = \App\Models\Player::factory()->create(['team_id' => $this->team->id, 'captain' => false]);
    $this->captain = \App\Models\Player::factory()->create(['team_id' => $this->team->id, 'captain' => true]);
    $this->owner = \App\Models\User::factory()->create();
    \App\Models\Venue::find(1)->update(['user_id' => $this->owner->id]);
    session()->put('cycle', \App\Models\Season::first()->cycle);
    session(['is_admin' => false]);
});

it('renders successfully', function () {
    Livewire::test(Teams::class)
        ->assertStatus(200);
});

it('has teams', function () {
    Livewire::test(Teams::class)
        ->assertViewHas('teams')
        ->assertCount('teams', 2);
});

it('shows the team and venue name', function () {
    Livewire::test(Teams::class)
        ->assertSee($this->team->name)
        ->assertSee($this->team->venue->name);
});

it('does not show the phone numbers as a guest', function () {
    Livewire::test(Teams::class)
        ->assertSee('hidden');
});

it('shows the phone numbers if logged in but can not edit', function () {
    Livewire::actingAs($this->player->user)
        ->test(Teams::class)
        ->assertSee($this->team->venue->contact_nr)
        ->assertDontSeeHtml('teams/edit')
        ->assertDontSeeHtml('venues/edit');
});

it('checks if the captain can edit the team', function () {
    Livewire::actingAs($this->captain->user)
        ->test(Teams::class)
        ->assertOk()
        ->assertSeeText($this->captain->user->contact_nr)
        ->assertSeeHtml('teams/edit/1')
        ->assertDontSeeHtml('venues/edit');
});

it('checks if the bar owner can edit the venue and shows their contact number', function () {
    Livewire::actingAs($this->owner)
        ->test(Teams::class)
        ->assertOk()
        ->assertSeeText($this->owner->contact_nr)
        ->assertSeeHtml('venues/edit/1');
});
