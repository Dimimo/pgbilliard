<?php

use App\Models\Date;
use App\Models\Event;
use App\Models\Player;
use App\Models\Season;
use App\Models\Team;
use App\Models\User;

beforeEach(function (): void {
    $this->publicSeason = Season::factory()->create([
        'cycle' => '2026/01',
        'is_public' => true,
    ]);
    $this->privateSeason = Season::factory()->create([
        'cycle' => '2026/02',
        'is_public' => false,
    ]);
    $this->publicTeam = Team::factory()->for($this->publicSeason)->create();
    $this->publicDate = Date::factory()->for($this->publicSeason)->create();
    $this->privateTeam = Team::factory()->for($this->privateSeason)->create();
    $this->privateOpponent = Team::factory()->for($this->privateSeason)->create();
    $this->participant = User::factory()->create();
    $this->privatePlayer = Player::factory()
        ->for($this->privateTeam)
        ->for($this->participant)
        ->create(['active' => true]);
    $this->privateDate = Date::factory()->for($this->privateSeason)->create();
    $this->privateEvent = Event::factory()
        ->for($this->privateDate)
        ->create([
            'team1' => $this->privateTeam->id,
            'team2' => $this->privateOpponent->id,
            'venue_id' => $this->privateTeam->venue_id,
        ]);
});

it('redirects private web resources for non-participants', function (string $resource): void {
    $path = match ($resource) {
        'date' => "/dates/show/{$this->privateDate->id}",
        'player' => "/players/show/{$this->privatePlayer->id}",
        'event' => "/schedule/event/{$this->privateEvent->id}",
        'singular team' => "/team/show/{$this->privateTeam->id}",
        'singular team edit' => "/team/edit/{$this->privateTeam->id}",
        'Folio team' => "/teams/show/{$this->privateTeam->id}",
        'Folio team edit' => "/teams/edit/{$this->privateTeam->id}",
        'score email' => "/mailable/date/{$this->privateDate->id}",
        'admin score email' => "/mailable/date/{$this->privateDate->id}/admin",
        'reminder email' => "/mailable/game-reminder/{$this->privateDate->id}/{$this->privateTeam->id}",
        'mixed reminder email' => "/mailable/game-reminder/{$this->publicDate->id}/{$this->privateTeam->id}",
    };

    $this->get($path)->assertRedirect(route('scoreboard'));
})->with([
    'date',
    'player',
    'event',
    'singular team',
    'singular team edit',
    'Folio team',
    'Folio team edit',
    'score email',
    'admin score email',
    'reminder email',
    'mixed reminder email',
]);

it('redirects a logged-in non-participant and preserves their public fallback', function (): void {
    $outsider = User::factory()->create();

    $this->actingAs($outsider)
        ->withSession([
            'cycle' => $this->publicSeason->cycle,
            'season_id' => $this->publicSeason->id,
        ])
        ->get("/teams/show/{$this->privateTeam->id}")
        ->assertRedirect(route('scoreboard'))
        ->assertSessionHas('cycle', $this->publicSeason->cycle)
        ->assertSessionHas('season_id', $this->publicSeason->id);
});

it('switches to a private season for an authorized direct link', function (): void {
    $this->actingAs($this->participant)
        ->withSession([
            'cycle' => $this->publicSeason->cycle,
            'season_id' => $this->publicSeason->id,
        ])
        ->get("/teams/show/{$this->privateTeam->id}")
        ->assertOk()
        ->assertSessionHas('cycle', $this->privateSeason->cycle)
        ->assertSessionHas('season_id', $this->privateSeason->id);
});

it('continues to expose public resources to guests', function (): void {
    $this->get("/teams/show/{$this->publicTeam->id}")->assertOk();
    $this->getJson("/api/team/{$this->publicTeam->id}")->assertOk();
});

it('exposes private API resources to active participants', function (): void {
    $this->actingAs($this->participant)
        ->getJson("/api/team/{$this->privateTeam->id}")
        ->assertOk();
});

it('returns not found for private API resources requested by non-participants', function (string $resource): void {
    $path = match ($resource) {
        'date' => "/api/date/{$this->privateDate->id}",
        'player' => "/api/player/{$this->privatePlayer->id}",
        'team' => "/api/team/{$this->privateTeam->id}",
        'event' => "/api/event/{$this->privateEvent->id}",
        'event schedule' => "/api/schedule/event/{$this->privateEvent->id}",
    };

    $this->getJson($path)->assertNotFound();
})->with(['date', 'player', 'team', 'event', 'event schedule']);
