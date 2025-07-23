<?php

use App\Livewire\Help\Schedule;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Schedule::class)
        ->assertStatus(200);
});
