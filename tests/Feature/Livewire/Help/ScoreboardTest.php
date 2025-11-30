<?php

use App\Livewire\Help\Scoreboard;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Scoreboard::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.help.scoreboard');
});
