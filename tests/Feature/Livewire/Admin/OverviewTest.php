<?php

use App\Livewire\Admin\Overview;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Overview::class)
        ->assertStatus(200);
});
