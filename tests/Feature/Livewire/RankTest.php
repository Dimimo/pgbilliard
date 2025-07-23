<?php

use App\Livewire\Rank;
use Livewire\Livewire;

it('renders successfully', function () {
    $rank = \App\Models\Rank::factory()->create();
    session()->put('cycle', $rank->season->cycle);

    Livewire::test(Rank::class)
        ->assertStatus(200);
});
