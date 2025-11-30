<?php

use App\Livewire\Admin\Schedule\Index;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Index::class)
        ->assertStatus(200);
});
