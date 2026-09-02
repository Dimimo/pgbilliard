<?php

use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('casts the public flag to a boolean', function (): void {
    $season = Season::factory()->create(['is_public' => false]);

    expect($season->is_public)->toBeFalse();
});

it('limits visible seasons to public seasons and active participation', function (): void {
    session(['is_admin' => false]);

    $user = User::factory()->create();
    $publicSeason = Season::factory()->create(['is_public' => true]);
    $participatingSeason = Season::factory()->create(['is_public' => false]);
    $inactiveSeason = Season::factory()->create(['is_public' => false]);
    $unrelatedSeason = Season::factory()->create(['is_public' => false]);

    Player::factory()
        ->for(Team::factory()->for($participatingSeason))
        ->for($user)
        ->create(['active' => true]);

    Player::factory()
        ->for(Team::factory()->for($inactiveSeason))
        ->for($user)
        ->create(['active' => false]);

    $visibleSeasonIds = Season::query()->visibleTo($user)->pluck('id');

    expect($visibleSeasonIds)
        ->toContain($publicSeason->id, $participatingSeason->id)
        ->not->toContain($inactiveSeason->id, $unrelatedSeason->id);
});

it('only exposes public seasons to guests', function (): void {
    $publicSeason = Season::factory()->create(['is_public' => true]);
    $privateSeason = Season::factory()->create(['is_public' => false]);

    $visibleSeasonIds = Season::query()->visibleTo(null)->pluck('id');

    expect($visibleSeasonIds)
        ->toContain($publicSeason->id)
        ->not->toContain($privateSeason->id);
});

it('allows administrators to see every season', function (): void {
    session(['is_admin' => true]);

    $admin = User::factory()->create();
    $publicSeason = Season::factory()->create(['is_public' => true]);
    $privateSeason = Season::factory()->create(['is_public' => false]);

    $visibleSeasonIds = Season::query()->visibleTo($admin)->pluck('id');

    expect($visibleSeasonIds)->toContain($publicSeason->id, $privateSeason->id);
});

it('authorizes public seasons and private seasons for active participants', function (): void {
    session(['is_admin' => false]);

    $participant = User::factory()->create();
    $outsider = User::factory()->create();
    $publicSeason = Season::factory()->create(['is_public' => true]);
    $privateSeason = Season::factory()->create(['is_public' => false]);

    Player::factory()
        ->for(Team::factory()->for($privateSeason))
        ->for($participant)
        ->create(['active' => true]);

    expect(Gate::allows('view', $publicSeason))->toBeTrue()
        ->and(Gate::forUser($participant)->allows('view', $privateSeason))->toBeTrue()
        ->and(Gate::forUser($outsider)->allows('view', $privateSeason))->toBeFalse();
});

it('does not authorize inactive players for a private season', function (): void {
    session(['is_admin' => false]);

    $user = User::factory()->create();
    $privateSeason = Season::factory()->create(['is_public' => false]);

    Player::factory()
        ->for(Team::factory()->for($privateSeason))
        ->for($user)
        ->create(['active' => false]);

    expect(Gate::forUser($user)->allows('view', $privateSeason))->toBeFalse();
});

it('authorizes administrators for a private season', function (): void {
    session(['is_admin' => true]);

    $admin = User::factory()->create();
    $privateSeason = Season::factory()->create(['is_public' => false]);

    expect(Gate::forUser($admin)->allows('view', $privateSeason))->toBeTrue();
});
