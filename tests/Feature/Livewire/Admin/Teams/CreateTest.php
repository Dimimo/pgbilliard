<?php

use App\Livewire\Admin\Teams\Create;
use Livewire\Livewire;

it('renders successfully', function (): void {
    $this->seed(\Database\Seeders\SeasonSeeder::class);
    Livewire::test(Create::class)
        ->assertStatus(200);
});
