<?php

use App\Livewire\CycleAll;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(CycleAll::class)
        ->assertStatus(200);
});
