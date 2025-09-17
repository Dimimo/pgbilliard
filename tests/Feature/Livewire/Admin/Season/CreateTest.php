<?php

use App\Livewire\Admin\Season\Create;
use App\Models\Season;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

test('can create a season in the database', function () {
    Season::factory()->create();

    $current_season = Season::query()->count();
    expect($current_season)->toBe(1);
});
