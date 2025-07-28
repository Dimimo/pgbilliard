<?php

use App\Livewire\Help\Calendar;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Calendar::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.help.calendar');
});
