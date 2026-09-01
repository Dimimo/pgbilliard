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
    $format = Format::factory()->create(['players' => $position === 15 ? 3 : 4]);
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

it('persists the player count and clears assignments above it', function (): void {
    $format = Format::factory()->create(['players' => 4]);
    $component = Livewire::test(Create::class, ['format' => $format]);
    $slot = $format->schedules()->wherePosition(1)->whereHome(true)->sole();

    $component
        ->call('player', $slot->id, 4)
        ->set('players', 3)
        ->assertHasNoErrors()
        ->assertSet('players', 3);

    expect($format->refresh()->players)->toBe(3)
        ->and($slot->refresh()->player)->toBe(0);
});

it('allows a three-player format to determine the third double', function (): void {
    $format = Format::factory()->create(['players' => 3]);
    $component = Livewire::test(Create::class, ['format' => $format]);
    $slots = $format->schedules()
        ->wherePosition(15)
        ->whereHome(true)
        ->orderBy('id')
        ->get();

    $component
        ->call('player', $slots->first()->id, 1)
        ->call('player', $slots->last()->id, 2)
        ->assertHasNoErrors();

    expect($format->schedules()->wherePosition(15)->whereHome(true)->pluck('player')->all())
        ->toBe([1, 2]);
});

it('keeps the third double undetermined for a four-player format', function (): void {
    $format = Format::factory()->create(['players' => 4]);
    $component = Livewire::test(Create::class, ['format' => $format]);
    $slot = $format->schedules()->wherePosition(15)->whereHome(true)->firstOrFail();

    $component
        ->assertSee('Selected on game day')
        ->call('player', $slot->id, 1)
        ->assertHasErrors('table');

    expect($slot->refresh()->player)->toBe(0);
});

it('clears a determined third double when changing away from three players', function (): void {
    $format = Format::factory()->create(['players' => 3]);
    $component = Livewire::test(Create::class, ['format' => $format]);
    $slots = $format->schedules()->wherePosition(15)->orderBy('id')->get();

    foreach ($slots as $index => $slot) {
        $component->call('player', $slot->id, $index % 3 + 1);
    }

    $component->set('players', 4)->assertHasNoErrors();

    expect($format->schedules()->wherePosition(15)->pluck('player')->unique()->all())
        ->toBe([0]);
});
