<?php

use App\Livewire\Rank;
use Livewire\Livewire;

beforeEach(function () {
    $this->season = \App\Models\Season::factory()->create();
    session(['cycle' => $this->season->cycle]);
});

it('renders successfully', function () {
    Livewire::test(Rank::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.rank');
});

it('tests the ranking order and names', function () {
    $this->seed(\Database\Seeders\RankSeeder::class);
    $first = \App\Models\Rank::query()->orderByDesc('percentage')->first();
    $last = \App\Models\Rank::query()->orderBy('played')->first();
    $playerCount = \App\Models\Player::query()->count();

    Livewire::test(Rank::class)
        ->assertDontSee($last->user->name)
        ->call('toggleMedian')
        ->assertSee($first->player->user->name)
        ->assertSee($last->player->user->name)
        ->assertCount('results', $playerCount);
});
