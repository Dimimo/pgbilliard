<?php

use App\Livewire\Snippets\VenueSelect;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(VenueSelect::class)
        ->assertStatus(200);
});
