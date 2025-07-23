<?php

use App\Livewire\Admin\Venue;
use Livewire\Livewire;

it('renders successfully', function () {
    $venue = \App\Models\Venue::factory()->create();
    Livewire::test(Venue::class, ['venue' => $venue->id])
        ->assertStatus(200);
});
