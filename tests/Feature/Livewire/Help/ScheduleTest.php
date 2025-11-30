<?php

use App\Livewire\Help\Schedule;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Schedule::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.help.schedule');
});
