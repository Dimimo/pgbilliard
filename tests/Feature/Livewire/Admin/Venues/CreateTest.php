<?php

use App\Livewire\Admin\Venues\Create;
use Livewire\Livewire;

it('renders successfully', function () {
    $venue = \App\Models\Venue::factory()->create();
    Livewire::test(Create::class, ['venue' => $venue->id])
        ->assertStatus(200);
});
