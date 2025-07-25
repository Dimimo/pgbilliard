<?php

use App\Livewire\Rank;
use Livewire\Livewire;

beforeEach(function () {
    $this->season = \App\Models\Season::factory()->create();
    session(['cycle' => $this->season->cycle]);
});

it('renders successfully', function () {
    Livewire::test(Rank::class)
        ->assertStatus(200);
});

it('tests the ranking order and names', function () {
    $this->seed(\Database\Seeders\RankSeeder::class);
    $first = \App\Models\Rank::orderByDesc('percentage')->first();
    $last = \App\Models\Rank::orderBy('played')->first();
    $playerCount = \App\Models\Player::count();

    Livewire::test(Rank::class)
        ->assertDontSee($last->user->name)
        ->call('toggleMedian')
        ->assertSee($first->player->user->name)
        ->assertSee($last->player->user->name)
        ->assertCount('results', $playerCount);
});
