<?php

use App\Livewire\Players\Details;
use Livewire\Livewire;

it('renders successfully', function () {
    $rank = \App\Models\Rank::factory()->create();
    $player = $rank->player;
    $season = $rank->season;
    session()->put('cycle', $season->cycle);

    Livewire::test(Details::class, ['player' => $player])
        ->assertStatus(200);
});
