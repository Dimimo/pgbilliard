<?php

use App\Livewire\Help\LiveScores;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(LiveScores::class)
        ->assertStatus(200);
});
