<?php

use App\Livewire\CycleAll;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(CycleAll::class)
        ->assertStatus(200);
});

it('shows the correct component', function (): void {
    $this->seed(\Database\Seeders\EventSeeder::class);
    $expected = "(" . \App\Models\Event::query()->count() . " games";

    $response = $this->get('/seasons');
    $response
        ->assertOk()
        ->assertSeeVolt('cycle-all')
        ->assertSee(Season::query()->first()->cycle)
        ->assertSee($expected);
});

it('hides private seasons from guests and rejects crafted selections', function (): void {
    $publicSeason = Season::factory()->create([
        'cycle' => '2026/01',
        'is_public' => true,
    ]);
    $privateSeason = Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);

    $component = Livewire::test(CycleAll::class)
        ->assertSee($publicSeason->cycle)
        ->assertDontSee($privateSeason->cycle);

    expect(fn () => $component->call('selectedSeason', $privateSeason->id))
        ->toThrow(ModelNotFoundException::class);
});

it('shows private seasons to active participants', function (): void {
    $user = User::factory()->create();
    $privateSeason = Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);

    Player::factory()
        ->for(Team::factory()->for($privateSeason))
        ->for($user)
        ->create(['active' => true]);

    $this->actingAs($user);

    Livewire::test(CycleAll::class)
        ->assertSee($privateSeason->cycle)
        ->call('selectedSeason', $privateSeason->id)
        ->assertSessionHas('cycle', $privateSeason->cycle)
        ->assertSessionHas('season_id', $privateSeason->id)
        ->assertRedirectToRoute('scoreboard');
});
