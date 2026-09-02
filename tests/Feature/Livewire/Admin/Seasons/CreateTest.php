<?php

use App\Livewire\Admin\Seasons\Create;
use App\Models\Season;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Create::class)
        ->assertStatus(200)
        ->assertSet('is_public', true)
        ->assertSee('Public Season');
});

test('can create a season in the database', function (): void {
    Season::factory()->create();

    $current_season = Season::query()->count();
    expect($current_season)->toBe(1);
});

it('can create a private season', function (): void {
    Livewire::test(Create::class)
        ->set('cycle', '2099/01')
        ->set('is_public', false)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect();

    $season = Season::query()->whereCycle('2099/01')->firstOrFail();

    expect($season->is_public)->toBeFalse()
        ->and($season->dates)->toHaveCount(1);
});
