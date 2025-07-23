<?php

use App\Livewire\Snippets\VenueSelect;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(VenueSelect::class)
        ->assertStatus(200);
});
