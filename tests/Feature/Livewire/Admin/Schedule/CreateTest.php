<?php

use App\Livewire\Admin\Schedule\Create;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Create::class)
        ->assertStatus(200);
});
