<?php

use App\Livewire\Team\Edit;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->seed(\Database\Seeders\CompleteSeasonSeeder::class);
    $this->team = \App\Models\Team::query()->find(1);
    session(['is_admin' => false]);
});

it('renders successfully', function (): void {
    $this->component = Livewire::test(Edit::class, ['team' => $this->team])
        ->assertStatus(200)
        ->assertSet('team_form.team', $this->team)
        ->assertCount('venues', 3);
});

it('a bar owner can edit the bar and team but cannot create a team', function (): void {
    $owner = $this->team->venue->owner;
    $this->actingAs($owner);
    $response = $this->get('/teams/edit/' . $this->team->id);
    $response
        ->assertSee("Edit the team")
        ->assertSee($this->team->name)
        ->assertSee('Edit this venue')
        ->assertDontSeeVolt('team.edit')
        ->assertSeeVolt('venue')
        ->assertSeeVolt('players.edit');
});

it('a captain can edit the team but cannot edit the bar', function (): void {
    $captain = $this->team->players()->where('captain', true)->first()->user;
    $this->actingAs($captain);
    $response = $this->get('/teams/edit/' . $this->team->id);
    $response
        ->assertSee("Edit the team")
        ->assertSee($this->team->name)
        ->assertDontSee('Edit this venue')
        ->assertDontSee('team.edit')
        ->assertSeeVolt('venue')
        ->assertSeeVolt('players.edit');
});

it('a guest can not see any edit of team or bar', function (): void {
    $response = $this->get('/teams/edit/' . $this->team->id);
    $response
        ->assertSee($this->team->name)
        ->assertDontSee('Edit this venue')
        ->assertDontSee('team.edit')
        ->assertDontSeeVolt('venue')
        ->assertDontSeeVolt('players.edit');
});
