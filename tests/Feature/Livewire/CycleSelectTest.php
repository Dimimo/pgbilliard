<?php

use App\Livewire\CycleSelect;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Livewire;

beforeEach(function (): void {
    Season::factory(4)->create();
    $this->component = Livewire::test(CycleSelect::class);
});

it('renders successfully', function (): void {
    $this->component
        ->assertStatus(200)
        ->assertOk();
});

it('shows all cycles in the right order', function (): void {
    $list = Season::query()
        ->distinct()
        ->orderByDesc('cycle')
        ->limit(4)
        ->get()
        ->pluck('cycle')
        ->toArray();

    $this->component
        ->assertSeeInOrder($list)
        ->assertSee('All Seasons');
});

it('redirects if a season is chosen', function (): void {
    $season = Season::query()->find(1);
    $this->component
        ->call('changeCycle', 1)
        ->assertSessionHas('cycle', $season->cycle)
        ->assertSessionHas('season_id', $season->id)
        ->assertRedirectToRoute('scoreboard');
});

it('hides private seasons from guests and rejects crafted selections', function (): void {
    $privateSeason = Season::factory()->create([
        'cycle' => '2099/01',
        'is_public' => false,
    ]);

    $component = Livewire::test(CycleSelect::class)
        ->assertDontSee($privateSeason->cycle);

    expect(fn () => $component->call('changeCycle', $privateSeason->id))
        ->toThrow(ModelNotFoundException::class);
});

it('shows private seasons to active participants', function (): void {
    $user = User::factory()->create();
    $privateSeason = Season::factory()->create([
        'cycle' => '2099/01',
        'is_public' => false,
    ]);

    Player::factory()
        ->for(Team::factory()->for($privateSeason))
        ->for($user)
        ->create(['active' => true]);

    $this->actingAs($user);

    Livewire::test(CycleSelect::class)
        ->assertSee($privateSeason->cycle)
        ->call('changeCycle', $privateSeason->id)
        ->assertSessionHas('cycle', $privateSeason->cycle)
        ->assertSessionHas('season_id', $privateSeason->id)
        ->assertRedirectToRoute('scoreboard');
});
