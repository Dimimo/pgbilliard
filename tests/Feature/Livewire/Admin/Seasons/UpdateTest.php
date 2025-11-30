<?php

use App\Livewire\Admin\Seasons\Update;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Update::class)
        ->assertStatus(200);
});
