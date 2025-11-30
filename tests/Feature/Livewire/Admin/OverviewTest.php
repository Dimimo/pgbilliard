<?php

use App\Livewire\Admin\Overview;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Overview::class)
        ->assertStatus(200);
});
