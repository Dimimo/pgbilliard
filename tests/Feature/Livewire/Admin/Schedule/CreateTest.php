<?php

use App\Livewire\Admin\Schedule\Create;
use App\Models\Format;
use App\Models\Schedule;
use App\Models\User;
use Livewire\Livewire;

it('renders successfully', function (): void {
    Livewire::test(Create::class)
        ->assertStatus(200);
});

it('creates a format with a complete schedule overlay', function (): void {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(Create::class)
        ->set('name', 'Classic format')
        ->set('details', 'The standard fifteen-game format')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('format-updated')
        ->assertCount('table', 36);

    $format = Format::query()->whereName('Classic format')->firstOrFail();

    expect($format->schedules)->toHaveCount(36)
        ->and($format->schedules()->whereIn('position', [5, 10, 15])->count())->toBe(12)
        ->and($format->schedules()->whereNotIn('position', [5, 10, 15])->count())->toBe(24);
});

it('updates an existing schedule slot instead of creating a duplicate', function (): void {
    $format = Format::factory()->create();
    $component = Livewire::test(Create::class, ['format' => $format]);
    $slot = $format->schedules()->wherePosition(1)->whereHome(true)->sole();

    $component
        ->call('player', $slot->id, 1)
        ->call('player', $slot->id, 2)
        ->assertHasNoErrors();

    expect(
        $format->schedules()->wherePosition(1)->whereHome(true)->get(),
    )->toHaveCount(1)
        ->and($slot->refresh()->player)->toBe(2);
});

it('edits both players in a double independently without creating duplicates', function (
    int $position,
): void {
    $format = Format::factory()->create();
    $component = Livewire::test(Create::class, ['format' => $format]);
    $slots = $format->schedules()
        ->wherePosition($position)
        ->whereHome(true)
        ->orderBy('id')
        ->get();

    $component
        ->call('player', $slots->first()->id, 1)
        ->call('player', $slots->last()->id, 2)
        ->call('player', $slots->first()->id, 3)
        ->assertHasNoErrors();

    $players = $format->schedules()
        ->wherePosition($position)
        ->whereHome(true)
        ->orderBy('player')
        ->pluck('player')
        ->all();

    expect($players)->toBe([2, 3]);
})->with([
    'first double' => 5,
    'second double' => 10,
    'third double' => 15,
]);

it('clears a schedule slot without removing it from the overlay', function (): void {
    $format = Format::factory()->create();
    $component = Livewire::test(Create::class, ['format' => $format]);
    $slot = $format->schedules()->wherePosition(5)->whereHome(false)->firstOrFail();

    $component
        ->call('player', $slot->id, 2)
        ->call('player', $slot->id, 0)
        ->assertHasNoErrors();

    expect(Schedule::query()->findOrFail($slot->id)->player)->toBe(0)
        ->and(
            $format->schedules()->wherePosition(5)->whereHome(false)->count(),
        )->toBe(2);
});
