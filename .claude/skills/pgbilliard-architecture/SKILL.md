---
name: pgbilliard-architecture
description: Domain model hierarchy, model relationships, and core business-logic patterns for the Puerto Galera Billiard League app — score-calculation flow, ranking formula, broadcasting/rescue() pattern, Context-facade season handling, and Livewire reactive/echo/attribute conventions. Load when working on scoring, ranks, events/games, broadcasting, or Livewire components.
---

# Architecture & Domain Knowledge

## Architecture Overview

### Domain Models and Relationships

The application follows a hierarchical structure:

```
SEASON → DATES → EVENTS → GAMES
         TEAMS → PLAYERS
         FORMATS → SCHEDULES
         RANKS
```

**Core Models**:

- `Season`: League cycle (e.g., 2024 season) with player count configuration
- `Date`: Individual play dates within a season
- `Event`: Match between two teams on a specific date (contains 15 games)
- `Game`: Individual game with player assignments, scores, and win/loss tracking
- `Team`: Team with venue, captain, and players
- `Player`: Individual player belonging to teams
- `Rank`: Player performance metrics per season (wins, losses, percentage)
- `Format`: Game format templates defining match structure
- `Schedule`: Specific game slots within a format (player positions)
- `Position`: Player lineup setup for an event
- `Venue`: Billiard hall location with contact info

**Supporting Models**:

- `User`: Authentication (linked to Player)
- `ChatRoom`, `ChatMessage`: Chat system
- `Post`, `Comment`, `Tag`: Forum system
- `Visit`: Post view tracking

**Important Relationships**:

- Season has many Dates, Teams, Formats, Ranks
- Date has many Events
- Event belongs to Date, has many Games and Positions
- Team belongs to Season and Venue, has many Players
- Player belongs to Team and User, has many Games and Ranks
- Game belongs to Event, references Players and Position

### Application Structure

**Route Layer** (`routes/web.php`):

- Uses Laravel Folio for file-based routing (pages in `resources/views/pages/`)
- Main sections: Public (scoreboard, ranks, calendar), Player (teams, schedule, forum, chat), Admin (calendar, schedule, season, player management)
- Protected routes use `auth` and `admin` middleware

**Livewire Component Layer** (`app/Livewire/`):

- **Core Components**: `Score.php` (live scores), `Rank.php` (rankings), `Calendar.php`, `Dashboard.php`
- **Score Management** (`Date/` directory): `ScheduleScoreTable.php` (real-time score entry with broadcasting), `SchedulePlayerSelector.php`, `ScheduleConfirm.php`, `ScheduleFormatChooser.php`, `Schedule.php`
- **Admin Components** (`Admin/` directory): Schedule/Calendar/Teams/Seasons/Players CRUD
- **Social Features**: `Chat/` (chat rooms), `Forum/` (posts/comments), `Team/` (team management)
- **Key Traits**: `ConsolidateTrait.php`, `ResultsTrait.php` (complex calculations)

**Service Layer** (`app/Services/`):

- `LiveScoreUpdater.php`: Calculates event scores from individual games
- `RankUpdater.php`: Calculates player rankings (percentage, wins/losses)
- `ScheduleManager.php`: Manages game schedule matrix and format selection
- `PlayerManager.php`: Player assignment and validation
- `Consolidator.php`: Score consolidation logic
- `Logger/LogGames.php`, `Logger/LogConsolidate.php`: Change logging

**Job Queue System** (`app/Jobs/`):

- `UpdateRanks`: Updates player rankings (ShouldQueue, ShouldBeUnique)
- `UpdateUsersLastPlayedDate`: Tracks last game date
- `PoolSetDayScores`: Consolidated score setting
- `PlayDayReminder`, `AccountHasBeenClaimed`, `CaptainCreatedNewUser`, `EmailHasBeenChanged`: Email notifications

**Broadcasting & Real-Time** (`routes/channels.php`, `app/Events/`):

- **Channels**: `live-score` (public), `refresh-request` (public), `chat.{roomId}` (private with presence)
- **Events**: `ScoreEvent` (ShouldBroadcastNow), `MessagePosted`, `PrivateMessagePosted`, `RefreshRequest`
- **Listeners**: `ScoreEventListener` (queued)
- Components listen with: `#[On('echo:live-score,ScoreEvent')]`

**Middleware** (`app/Http/Middleware/`):

- `PoolCycle` & `PoolCycleApi`: Sets current season context in `Context` facade
- `TeamOfLoggedInUserMiddleware`: Validates user's team access
- `CheckIfAdmin` & `IsAdmin`: Admin role validation
- `DetectAndroid`: Mobile platform detection

### Key Business Logic Patterns

**Score Calculation Flow**:

1. User updates game result in `ScheduleScoreTable` component
2. Game record updated with `win` field (true/false/null)
3. `LiveScoreUpdater` service calculates event scores from all 15 games
4. `ScoreEvent` broadcasts via Reverb/Ably to all listeners
5. `UpdateRanks` job queued to recalculate player rankings
6. `Rank.php` component receives broadcast and updates display

**Ranking Calculation** (`RankUpdater`):

- Aggregates wins/losses across all games for a player
- Considers days participated (attended events)
- Formula: `(won/played * 100) * (participated/maxParticipated)` capped at 100
- Updates `ranks` table for display

**Context Management**:

- Current season stored in session context via `Context` facade
- Retrieved with `Context::getHidden('season_id')`
- Set by `PoolCycle` middleware based on session or default

**Broadcasting Pattern**:

```php
// Wrapped in rescue() to handle Ably connection errors gracefully
rescue(fn() => broadcast(new ScoreEvent(...))->toOthers());
```

**Authorization**:

- Policy-based authorization: `$this->authorize('update', $game->event);`
- Policies in `app/Policies/` directory
- User must belong to team's season to access/update

### Livewire Patterns

**Reactive Properties**:

```php
#[Reactive]
public ?Format $format = null;
```

Properties marked `#[Reactive]` update automatically when parent changes.

**Event Listening**:

```php
#[On('echo:live-score,ScoreEvent')]
public function updateLiveScores(array $response): void
```

Listen to Laravel Echo broadcasts from Reverb/Ably.

**Model Attributes**:

- Many models use `Attribute::make(get: fn() => ...)` for computed properties
- Example: `Player->name`, `Player->phone`, `Player->email` derived from relations
- Privacy-aware attributes check authentication before exposing data
