<?php

use App\Livewire\Admin\Seasons\Create;
use App\Models\Season;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

test('can create a season in the database', function (): void {
    Season::factory()->create();

    $current_season = Season::query()->count();
    expect($current_season)->toBe(1);
});
