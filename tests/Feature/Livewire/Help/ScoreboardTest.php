<?php

use App\Livewire\Help\Scoreboard;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Scoreboard::class)
        ->assertStatus(200);
});
