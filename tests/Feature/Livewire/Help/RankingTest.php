<?php

use App\Livewire\Help\Ranking;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Ranking::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.help.ranking');
});
