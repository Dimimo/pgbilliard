# Design Patterns and Architectural Decisions

## Overview

This document outlines the key design patterns and architectural decisions used throughout the Puerto Galera Billiard League application.

## Design Patterns

### Model-View-Controller (MVC)

While Laravel uses MVC as its foundation, this application extends it with Livewire components that combine controller logic with view rendering.

**Traditional Flow:**

```text
Request → Route → Controller → Model → View → Response
```

**Livewire Flow:**

```text
Request → Route → Livewire Component → Model → Render → Response
         ↑                                              ↓
         └──────────── WebSocket Updates ──────────────┘
```

### Repository Pattern (Selective Use)

The application uses Eloquent models directly for most operations, but implements repository-like patterns in specific areas:

**Example: Statistics Calculation**

```php
// app/Models/Player.php
public function getWinPercentageAttribute(): float
{
    $totalGames = $this->games()->count();
    if ($totalGames === 0) {
        return 0;
    }

    $wins = $this->games()->where('won', true)->count();
    return ($wins / $totalGames) * 100;
}
```

### Event-Driven Architecture

The application uses Laravel's event system for decoupled communication between components.

**Example: Score Update Event**

```php
// When a score is updated
event(new ScoreUpdated($game));

// Listeners handle the side effects
class UpdateRankings
{
    public function handle(ScoreUpdated $event): void
    {
        // Recalculate team rankings
    }
}

class BroadcastScoreUpdate
{
    public function handle(ScoreUpdated $event): void
    {
        // Broadcast to connected clients
    }
}
```

### Observer Pattern

Eloquent model observers are used to handle model lifecycle events.

**Example: Team Observer**

```php
class TeamObserver
{
    public function created(Team $team): void
    {
        // Initialize team statistics
        $team->rank()->create([
            'points' => 0,
            'games_played' => 0,
        ]);
    }

    public function deleting(Team $team): void
    {
        // Clean up related records
        $team->players()->detach();
    }
}
```

### Command Pattern

Laravel's Artisan commands encapsulate business logic that can be executed via CLI or scheduling.

**Example: Backup Command**

```php
// app/Console/Commands/BackupDatabase.php
class BackupDatabase extends Command
{
    protected $signature = 'backup:database';

    public function handle(): void
    {
        // Execute backup logic
    }
}
```

### Strategy Pattern

Different game formats (singles, doubles) use strategy pattern for scoring.

**Conceptual Example:**

```php
interface GameFormatStrategy
{
    public function calculatePoints(Game $game): int;
    public function validateTeamSize(int $size): bool;
}

class SinglesFormat implements GameFormatStrategy
{
    public function calculatePoints(Game $game): int
    {
        return $game->won ? 1 : 0;
    }

    public function validateTeamSize(int $size): bool
    {
        return $size >= 1;
    }
}

class DoublesFormat implements GameFormatStrategy
{
    public function calculatePoints(Game $game): int
    {
        return $game->won ? 2 : 0;
    }

    public function validateTeamSize(int $size): bool
    {
        return $size >= 2;
    }
}
```

## Architectural Decisions

### ADR-001: Use Livewire for Frontend

**Context:**

Need to build a dynamic, real-time interface for game scoring and statistics.

**Decision:**

Use Livewire as the primary frontend framework instead of a separate SPA (Vue/React).

**Rationale:**

1. **Team Expertise**: PHP-focused development team
2. **Rapid Development**: Faster development without API layer
3. **SEO Benefits**: Server-side rendering improves search visibility
4. **Real-time Support**: Built-in WebSocket support
5. **Reduced Complexity**: No need for separate frontend/backend deployments

**Consequences:**

- ✅ Faster development cycle
- ✅ Simplified deployment
- ✅ Better SEO performance
- ❌ Less flexibility for mobile apps (mitigated with PWA)
- ❌ Higher server load for real-time features

### ADR-002: Single Main Branch Deployment

**Context:**

Small hobby project with a single production environment.

**Decision:**

Use only the `main` branch without semantic versioning or release management.

**Rationale:**

1. **Simplicity**: Reduces overhead for small team
2. **Quick Fixes**: Deploy fixes immediately
3. **No Rollbacks**: Updates are forward-only with `git pull`

**Consequences:**

- ✅ Simplified workflow
- ✅ Quick deployments
- ❌ No version history
- ❌ Cannot rollback easily
- ❌ Risk of breaking changes

### ADR-003: Redis for Caching and Queues

**Context:**

Need for fast caching and background job processing.

**Decision:**

Use Redis as the unified backend for cache, sessions, and queues.

**Rationale:**

1. **Performance**: In-memory data store with sub-millisecond latency
2. **Simplicity**: Single service for multiple needs
3. **Scalability**: Easy to scale horizontally

**Consequences:**

- ✅ Improved performance
- ✅ Simplified infrastructure
- ❌ Additional service to maintain
- ❌ Potential single point of failure

### ADR-004: AWS S3 for File Storage

**Context:**

Need to store player photos, team logos, and other assets.

**Decision:**

Use AWS S3 via Laravel Flysystem for file storage.

**Rationale:**

1. **Reliability**: 99.999999999% durability
2. **Scalability**: No storage limits
3. **Cost-Effective**: Pay only for what you use
4. **CDN Integration**: Easy CloudFront integration

**Consequences:**

- ✅ Reliable storage
- ✅ No server disk space concerns
- ❌ External dependency
- ❌ AWS costs (minimal for hobby project)

### ADR-005: Soft Deletes by Default

**Context:**

Need to maintain data integrity and audit trail.

**Decision:**

Use soft deletes for most models instead of hard deletes.

**Rationale:**

1. **Data Recovery**: Ability to restore accidentally deleted records
2. **Audit Trail**: Maintain historical data
3. **Referential Integrity**: Avoid breaking relationships

**Consequences:**

- ✅ Data safety
- ✅ Better audit capabilities
- ❌ Larger database size
- ❌ Need to consider soft deletes in queries

### ADR-006: Real-time Updates via Laravel Reverb

**Context:**

Need real-time score updates for spectators and players.

**Decision:**

Use Laravel Reverb (first-party WebSocket server) for real-time features.

**Rationale:**

1. **Native Integration**: First-party Laravel solution
2. **Simplicity**: Easier setup than third-party solutions
3. **Cost**: No external service costs
4. **Fallback**: Ably as backup broadcasting driver

**Consequences:**

- ✅ Native Laravel integration
- ✅ No third-party costs
- ❌ Need to manage WebSocket server
- ❌ May need scaling for high traffic

### ADR-007: Minimal API Layer

**Context:**

Application is primarily web-based with Livewire.

**Decision:**

Provide minimal REST API only for specific needs (mobile app, webhooks).

**Rationale:**

1. **Focus**: Web interface is primary use case
2. **Simplicity**: Less code to maintain
3. **Security**: Smaller attack surface

**Consequences:**

- ✅ Reduced complexity
- ✅ Faster development
- ❌ Limited external integrations
- ❌ Need API development if mobile app is needed

## Code Organization Principles

### Component-Based Structure

Livewire components are organized by feature:

```text
app/Livewire/
├── Admin/          # Administrative features
├── Auth/           # Authentication components
├── Chat/           # Chat functionality
├── Date/           # Game scheduling
├── Forum/          # Forum features
├── Players/        # Player management
├── Snippets/       # Reusable UI components
└── Team/           # Team management
```

### Model Relationships

Models define relationships explicitly:

```php
// app/Models/Team.php
class Team extends Model
{
    public function players(): BelongsToMany
    {
        return $this->belongsToMany(Player::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public function rank(): HasOne
    {
        return $this->hasOne(Rank::class);
    }
}
```

### Validation at Request Level

Input validation happens in Form Request classes or Livewire component validation:

```php
// Livewire component validation
class CreateTeam extends Component
{
    public string $name;
    public string $logo;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:teams',
            'logo' => 'nullable|image|max:1024',
        ];
    }
}
```

### Policy-Based Authorization

Authorization logic is centralized in policy classes:

```php
// app/Policies/TeamPolicy.php
class TeamPolicy
{
    public function update(User $user, Team $team): bool
    {
        return $user->isAdmin() || $user->isCaptainOf($team);
    }
}
```

## Testing Strategy

### Feature Tests

Test complete user flows:

```php
test('team captain can update team information', function () {
    $captain = User::factory()->create();
    $team = Team::factory()->create(['captain_id' => $captain->id]);

    $this->actingAs($captain)
        ->livewire(EditTeam::class, ['team' => $team])
        ->set('name', 'New Team Name')
        ->call('save')
        ->assertHasNoErrors();

    expect($team->fresh()->name)->toBe('New Team Name');
});
```

### Unit Tests

Test individual components and methods:

```php
test('player win percentage calculation', function () {
    $player = Player::factory()->create();

    Game::factory()->count(7)->create([
        'player_id' => $player->id,
        'won' => true,
    ]);

    Game::factory()->count(3)->create([
        'player_id' => $player->id,
        'won' => false,
    ]);

    expect($player->win_percentage)->toBe(70.0);
});
```

## Best Practices

### 1. Use Eloquent Relationships

❌ Bad:

```php
$team = Team::find($id);
$players = Player::where('team_id', $team->id)->get();
```

✅ Good:

```php
$team = Team::find($id);
$players = $team->players;
```

### 2. Use Route Model Binding

❌ Bad:

```php
public function show($id)
{
    $team = Team::findOrFail($id);
    // ...
}
```

✅ Good:

```php
public function show(Team $team)
{
    // Laravel automatically resolves the model
}
```

### 3. Use Policies for Authorization

❌ Bad:

```php
if ($user->id === $team->captain_id || $user->is_admin) {
    // Update team
}
```

✅ Good:

```php
$this->authorize('update', $team);
// Update team
```

### 4. Use Events for Side Effects

❌ Bad:

```php
public function updateScore(Game $game, int $score)
{
    $game->update(['score' => $score]);
    $this->updateRankings($game->team);
    $this->broadcastUpdate($game);
    $this->notifyPlayers($game);
}
```

✅ Good:

```php
public function updateScore(Game $game, int $score)
{
    $game->update(['score' => $score]);
    event(new ScoreUpdated($game));
}
```

## References

- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Livewire Best Practices](https://livewire.laravel.com/docs/best-practices)
- [Design Patterns in PHP](https://designpatternsphp.readthedocs.io/)
