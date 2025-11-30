<?php

use App\Livewire\Players\Schedule;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Schedule::class)
        ->assertStatus(200);
});
