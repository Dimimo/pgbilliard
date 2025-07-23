<?php

use App\Livewire\CycleSelect;
use Livewire\Livewire;

it('renders successfully', function () {
    \App\Models\Season::factory()->create();
    Livewire::test(CycleSelect::class)
        ->assertStatus(200);
});
