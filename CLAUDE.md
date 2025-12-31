# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Puerto Galera Billiard League is a Laravel-based web application for managing a local billiard (pool) league in Puerto Galera, Philippines. The application handles team and player management, game scheduling and live scoring, real-time updates via WebSockets, rankings and statistics, and community features (forum, chat).

**Important**: This codebase is **not versioned**. Changes and bug fixes are deployed directly to the main branch with `git pull` on the production server.

## Technology Stack

- **Backend**: Laravel 12, PHP 8.3
- **Frontend**: Livewire 3.6, Volt, Folio, Tailwind CSS 4, Alpine.js
- **Database**: MySQL 8.0+
- **Cache/Queue**: Redis 6.0+ with Predis client
- **Real-time**: Laravel Reverb (WebSocket server) with Ably broadcasting
- **Storage**: AWS S3 (or public disk for local dev)
- **Testing**: Pest PHP 3 / PHPUnit 11
- **Quality Tools**: Laravel Pint (code style), Larastan/PHPstan (static analysis), Rector (refactoring), Stylelint (CSS)

## Common Commands

### Development Servers

Run these in separate terminals:

```bash
# PHP development server
php artisan serve

# Vite development server with HMR
npm run dev

# WebSocket server (Reverb) - use --debug for verbose output
php artisan reverb:start
php artisan reverb:start --debug

# Queue worker (if working with background jobs)
php artisan queue:work
php artisan queue:listen  # Auto-reloads on code changes
```

### Build and Assets

```bash
# Production build
npm run build

# Development mode with watch
npm run dev
```

### Testing

```bash
# Run all tests
php artisan test
./vendor/bin/pest

# Run specific test file
php artisan test tests/Feature/Team/TeamManagementTest.php

# Run tests matching pattern
php artisan test --filter team
php artisan test --filter "can create team"

# Run with coverage
php artisan test --coverage
php artisan test --coverage --min=80

# Run tests in parallel
php artisan test --parallel
```

### Code Quality

```bash
# Fix code style with Laravel Pint
./vendor/bin/pint

# Check code style without fixing
./vendor/bin/pint --test

# Run static analysis with Larastan
./vendor/bin/phpstan analyse

# Run Rector for automated refactoring
./vendor/bin/rector process
./vendor/bin/rector process --dry-run  # Preview changes

# Lint CSS with Stylelint
npm run lint:css  # if configured in package.json
```

### Database

```bash
# Run migrations
php artisan migrate

# Rollback last migration batch
php artisan migrate:rollback

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Run specific seeder
php artisan db:seed --class=TeamSeeder
```

### Cache Management

```bash
# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear

# Cache for production (after deployment)
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### IDE Helpers

```bash
# Generate IDE helper files (for better autocompletion)
php artisan ide-helper:generate
php artisan ide-helper:models --nowrite
php artisan ide-helper:meta
```

### Other Useful Commands

```bash
# Interactive REPL for testing code
php artisan tinker

# Generate API documentation (Scribe)
php artisan scribe:generate

# Manual backup
php artisan backup:run
php artisan backup:list

# Create storage symlink
php artisan storage:link
```

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

## Development Workflow

### Adding a New Feature

1. **Create migration** if database changes needed: `php artisan make:migration create_table_name_table`
2. **Create model** with factory: `php artisan make:model ModelName -mfs`
3. **Create Livewire component** if interactive UI: `php artisan make:livewire ComponentName`
4. **Create service** if complex business logic: Create in `app/Services/`
5. **Create job** if background processing: `php artisan make:job JobName`
6. **Create policy** if authorization needed: `php artisan make:policy PolicyName --model=ModelName`
7. **Write tests**: Create feature and unit tests in `tests/` directory
8. **Run quality checks**: `./vendor/bin/pint && ./vendor/bin/phpstan analyse`

### Working with Livewire Components

- Component files in `app/Livewire/`, views in `resources/views/livewire/`
- Use `#[Reactive]` for properties that should update from parent
- Use `#[On('event-name')]` to listen to events
- Dispatch events with `$this->dispatch('event-name', data: $data)`
- For real-time updates, listen to Echo events: `#[On('echo:channel,Event')]`

### Working with Broadcasting

1. Define event in `app/Events/` implementing `ShouldBroadcast` or `ShouldBroadcastNow`
2. Define channel in `routes/channels.php`
3. Dispatch event: `event(new EventName($data))`
4. Listen in Livewire: `#[On('echo:channel-name,EventName')]`
5. Always wrap broadcast calls in `rescue()` to handle connection errors

### Creating Tests

- Use Pest PHP syntax: `test('description', function() { ... })`
- Feature tests in `tests/Feature/`, unit tests in `tests/Unit/`
- Always use factories: `Team::factory()->create(['name' => 'Test'])`
- Structure tests with Arrange-Act-Assert pattern
- Test real-time features: Use `Event::fake()`, `Queue::fake()`, `Mail::fake()`

## Important Conventions

1. **No Versioning**: All changes go directly to main branch, deployed with `git pull`
2. **Model Naming**: Singular names (Player, Game, Team)
3. **Livewire Components**: PascalCase directory structure
4. **Broadcasting**: Public channels for general updates, private for user-specific
5. **Authorization**: Policy-based, user must belong to team's season
6. **Context**: Current season stored in session context, accessed via `Context` facade
7. **Error Handling**: Wrap broadcasts in `rescue()` to handle Ably connection issues
8. **Commit Messages**: Prefix with action (Add/Update/Fix/Refactor/Remove/Docs)

## File Structure

```
app/
├── Models/              Core domain models + Chat/Forum namespaces
├── Livewire/           Component-based UI with reactive properties
├── Services/           Business logic classes
├── Jobs/               Queue jobs for async processing
├── Events/             Broadcasting events
├── Listeners/          Event handlers
├── Http/
│   ├── Controllers/    Minimal - mostly Livewire components
│   ├── Middleware/     Custom middleware (PoolCycle, IsAdmin, etc.)
│   ├── Requests/       Form validation
│   └── Resources/      API resource classes
├── Mail/               Mailable classes
├── Policies/           Authorization policies
├── Traits/             Shared logic (ResultsTrait, CalendarTrait, etc.)
└── Constants.php       Application constants

resources/
├── views/
│   ├── pages/          Laravel Folio pages (file-based routing)
│   ├── livewire/       Livewire component views
│   └── components/     Blade components
├── js/                 JavaScript (Alpine.js, Echo setup)
└── css/                Tailwind CSS

routes/
├── web.php             Main routes (uses Folio)
├── channels.php        Broadcasting channels
└── console.php         Artisan commands

tests/
├── Feature/            Feature tests (end-to-end)
├── Unit/               Unit tests (isolated)
├── Pest.php            Pest configuration
└── TestCase.php        Base test case
```

## Debugging

- **Laravel Debugbar**: Enabled when `APP_DEBUG=true`, shows SQL queries, view data, route info
- **Tinker**: Interactive REPL - `php artisan tinker`
- **Logs**: `tail -f storage/logs/laravel.log`
- **Livewire**: Check browser console for Livewire errors
- **Broadcasting**: Use `php artisan reverb:start --debug` to see WebSocket messages
- **Tests**: Run with `-vv` for verbose output: `php artisan test -vv`

## Production Deployment

The application uses a simple deployment model:

```bash
git pull
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
php artisan optimize
```

Then restart services:
- PHP-FPM / Apache / Nginx
- Queue workers (`php artisan queue:restart`)
- Reverb server (if running as daemon)

## Additional Resources

- Full documentation in `docs/` directory
- Architecture details: `docs/01-architecture/`
- Development guides: `docs/02-development/`
- Deployment guides: `docs/03-deployment/`
- API documentation: `docs/04-api/` or generated with `php artisan scribe:generate`
