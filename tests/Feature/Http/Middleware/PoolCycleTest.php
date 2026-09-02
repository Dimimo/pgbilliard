<?php

use App\Models\Admin;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;

it('defaults guests to the latest public season', function (): void {
    $publicSeason = Season::factory()->create([
        'cycle' => '2026/01',
        'is_public' => true,
    ]);
    Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);

    $this->get('/privacy-policy')
        ->assertOk()
        ->assertSessionHas('cycle', $publicSeason->cycle)
        ->assertSessionHas('season_id', $publicSeason->id);
});

it('defaults active participants to their latest visible season', function (): void {
    $user = User::factory()->create();
    Season::factory()->create([
        'cycle' => '2026/01',
        'is_public' => true,
    ]);
    $privateSeason = Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);

    Player::factory()
        ->for(Team::factory()->for($privateSeason))
        ->for($user)
        ->create(['active' => true]);

    $this->actingAs($user)
        ->get('/privacy-policy')
        ->assertOk()
        ->assertSessionHas('cycle', $privateSeason->cycle)
        ->assertSessionHas('season_id', $privateSeason->id);
});

it('replaces an unauthorized private season stored in the session', function (): void {
    $publicSeason = Season::factory()->create([
        'cycle' => '2026/01',
        'is_public' => true,
    ]);
    $privateSeason = Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);

    $this->withSession([
        'cycle' => $privateSeason->cycle,
        'season_id' => $privateSeason->id,
        'my_team' => 123,
    ])->get('/privacy-policy')
        ->assertOk()
        ->assertSessionHas('cycle', $publicSeason->cycle)
        ->assertSessionHas('season_id', $publicSeason->id)
        ->assertSessionMissing('my_team');
});

it('preserves an authorized season stored in the session', function (): void {
    $selectedSeason = Season::factory()->create([
        'cycle' => '2025/02',
        'is_public' => true,
    ]);
    Season::factory()->create([
        'cycle' => '2026/01',
        'is_public' => true,
    ]);

    $this->withSession([
        'cycle' => $selectedSeason->cycle,
        'season_id' => $selectedSeason->id,
    ])->get('/privacy-policy')
        ->assertOk()
        ->assertSessionHas('cycle', $selectedSeason->cycle)
        ->assertSessionHas('season_id', $selectedSeason->id);
});

it('allows administrators to default to the latest private season', function (): void {
    $admin = User::factory()->create();
    Admin::factory()->create([
        'user_id' => $admin->id,
        'assigned_by' => $admin->id,
    ]);
    Season::factory()->create([
        'cycle' => '2026/01',
        'is_public' => true,
    ]);
    $privateSeason = Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);

    $this->actingAs($admin)
        ->get('/privacy-policy')
        ->assertOk()
        ->assertSessionHas('cycle', $privateSeason->cycle)
        ->assertSessionHas('season_id', $privateSeason->id);
});

it('clears the current season when no season is visible', function (): void {
    $privateSeason = Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);

    $this->withSession([
        'cycle' => $privateSeason->cycle,
        'season_id' => $privateSeason->id,
    ])->get('/privacy-policy')
        ->assertOk()
        ->assertSessionMissing('cycle')
        ->assertSessionMissing('season_id');
});
