# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Puerto Galera Billiard League is a Laravel-based web application for managing a local billiard (pool) league in Puerto Galera, Philippines. The application handles team and player management, game scheduling and live scoring, real-time updates via WebSockets, rankings and statistics, and community features (forum, chat).

**Important**: This codebase is **not versioned**. Changes and bug fixes are deployed directly to the main branch with `git pull` on the production server.

## Technology Stack

- **Backend**: Laravel 13, PHP 8.3
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

===

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.3
- laravel/breeze (BREEZE) - v2
- laravel/folio (FOLIO) - v1
- laravel/framework (LARAVEL) - v13
- laravel/pint (PINT) - v1
- laravel/prompts (PROMPTS) - v0
- laravel/reverb (REVERB) - v1
- laravel/sanctum (SANCTUM) - v4
- livewire/livewire (LIVEWIRE) - v3
- livewire/volt (VOLT) - v1
- larastan/larastan (LARASTAN) - v3
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v3
- phpunit/phpunit (PHPUNIT) - v11
- rector/rector (RECTOR) - v2
- laravel-echo (ECHO) - v2
- prettier (PRETTIER) - v3
- tailwindcss (TAILWINDCSS) - v4

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `npm run build`, `npm run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
    - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== herd rules ===

# Laravel Herd

- The application is served by Laravel Herd at `https?://[kebab-case-project-dir].test`. Use the `get-absolute-url` tool to generate valid URLs. Never run commands to serve the site. It is always available.
- Use the `herd` CLI to manage services, PHP versions, and sites (e.g. `herd sites`, `herd services:start <service>`, `herd php:list`). Run `herd list` to discover all available commands.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== folio/core rules ===

# Laravel Folio

- Laravel Folio is a powerful page-based router that simplifies routing in Laravel applications.
- Routes are generated automatically by creating Blade templates in `resources/views/pages`.
- IMPORTANT: Activate 'folio-routing' when working with Folio, pages, routes, route parameters, model binding, middleware, or `resources/views/pages`.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `npm run build` or ask the user to run `npm run dev` or `composer run dev`.

=== laravel/v13 rules ===

# Laravel 13

- Since Laravel 11/12, Laravel has a new streamlined file structure which this project uses.

## Laravel 13 Structure

- In Laravel 13, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app/Console/Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

## Database

- When modifying a column, the migration must include all the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 13 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== livewire/core rules ===

# Livewire

- Livewire allow to build dynamic, reactive interfaces in PHP without writing JavaScript.
- You can use Alpine.js for client-side interactions instead of JavaScript frameworks.
- Keep state server-side so the UI reflects it. Validate and authorize in actions as you would in HTTP requests.

=== volt/core rules ===

# Livewire Volt

- Single-file Livewire components: PHP logic and Blade templates in one file.
- Always check existing Volt components to determine functional vs class-based style.
- IMPORTANT: Always use `search-docs` tool for version-specific Volt documentation and updated code examples.
- IMPORTANT: Activate `volt-development` every time you're working with a Volt or single-file component-related task.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

</laravel-boost-guidelines>
