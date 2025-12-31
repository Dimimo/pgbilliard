# Data Layer

## Overview

This document describes the database schema, models, and data relationships in the Puerto Galera Billiard League application.

## Database Schema

### Entity Relationship Diagram

```text
┌─────────────┐       ┌──────────────┐       ┌─────────────┐
│   Season    │       │    Venue     │       │   Format    │
│─────────────│       │──────────────│       │─────────────│
│ id          │       │ id           │       │ id          │
│ name        │◄──┐   │ name         │◄──┐   │ name        │
│ year        │   │   │ address      │   │   │ description │
│ active      │   │   │ contact      │   │   │ rules       │
│ start_date  │   │   │ created_at   │   │   │ created_at  │
│ end_date    │   │   │ updated_at   │   │   │ updated_at  │
│ created_at  │   │   │ deleted_at   │   │   │ deleted_at  │
│ updated_at  │   │   └──────────────┘   │   └─────────────┘
│ deleted_at  │   │                      │
└─────────────┘   │                      │
                  │                      │
                  │   ┌──────────────┐   │
                  │   │     Date     │   │
                  │   │──────────────│   │
                  │   │ id           │   │
                  └───┤ season_id    │   │
                      ├ venue_id     ├───┘
                      │ date         │
                      │ time         │
                      │ status       │
                      │ created_at   │
                      │ updated_at   │
                      │ deleted_at   │
                      └──────┬───────┘
                             │
                             │
        ┌────────────────────┴────────────────────┐
        │                                         │
        ▼                                         ▼
┌──────────────┐                         ┌──────────────┐
│   Schedule   │                         │     Game     │
│──────────────│                         │──────────────│
│ id           │                         │ id           │
│ date_id      │◄────────────────────────┤ date_id      │
│ team_home_id │                         │ team_home_id │
│ team_away_id │                         │ team_away_id │
│ created_at   │                         │ format_id    │
│ updated_at   │                         │ player1_id   │
│ deleted_at   │                         │ player2_id   │
└──────┬───────┘                         │ score_home   │
       │                                 │ score_away   │
       │                                 │ won_by       │
       │                                 │ game_number  │
       │                                 │ created_at   │
       │                                 │ updated_at   │
       │                                 │ deleted_at   │
       │                                 └──────┬───────┘
       │                                        │
       │                                        │
       └────────┬───────────────────────────────┘
                │
                │
        ┌───────▼────────┐
        │      Team      │
        │────────────────│
        │ id             │
        │ name           │
        │ logo           │
        │ venue_id       │
        │ captain_id     ├───┐
        │ season_id      │   │
        │ created_at     │   │
        │ updated_at     │   │
        │ deleted_at     │   │
        └────────┬───────┘   │
                 │           │
                 │           │
                 └───────┐   │
                         │   │
                         ▼   │
                ┌──────────────┐
                │    Player    │
                │──────────────│
                │ id           │
                │ user_id      ├───┐
                │ name         │   │
                │ photo        │   │
                │ active       │   │
                │ created_at   │   │
                │ updated_at   │   │
                │ deleted_at   │   │
                └──────┬───────┘   │
                       │           │
                       │           │
               ┌───────▼───────┐   │
               │  player_team  │   │
               │───────────────│   │
               │ player_id     │   │
               │ team_id       │   │
               │ created_at    │   │
               │ updated_at    │   │
               └───────────────┘   │
                                   │
                                   │
                         ┌─────────▼────────┐
                         │      User        │
                         │──────────────────│
                         │ id               │
                         │ name             │
                         │ email            │
                         │ password         │
                         │ email_verified   │
                         │ remember_token   │
                         │ created_at       │
                         │ updated_at       │
                         └──────────────────┘


┌─────────────┐       ┌──────────────┐
│    Rank     │       │    Event     │
│─────────────│       │──────────────│
│ id          │       │ id           │
│ team_id     │       │ title        │
│ season_id   │       │ description  │
│ points      │       │ date         │
│ games_won   │       │ type         │
│ games_lost  │       │ created_at   │
│ position    │       │ updated_at   │
│ created_at  │       │ deleted_at   │
│ updated_at  │       └──────────────┘
└─────────────┘
```

## Core Models

### User

Represents authenticated users of the system.

**File**: `app/Models/User.php`

**Key Relationships:**

- `hasOne(Player)` - User profile as a player
- `hasMany(ForumPost)` - Forum posts created by user
- `hasMany(ChatMessage)` - Chat messages sent by user

**Key Attributes:**

- `name`: User's full name
- `email`: Unique email address
- `email_verified_at`: Email verification timestamp
- `password`: Hashed password

**Key Methods:**

- `isAdmin()`: Check if user has admin privileges
- `isCaptainOf(Team)`: Check if user is captain of a team

### Season

Represents a league season.

**File**: `app/Models/Season.php`

**Key Relationships:**

- `hasMany(Team)` - Teams participating in the season
- `hasMany(Date)` - Game dates in the season
- `hasMany(Rank)` - Team rankings for the season

**Key Attributes:**

- `name`: Season name (e.g., "Spring 2024")
- `year`: Season year
- `active`: Boolean indicating current season
- `start_date`: Season start date
- `end_date`: Season end date

### Team

Represents a billiard team.

**File**: `app/Models/Team.php`

**Key Relationships:**

- `belongsTo(Season)` - Season the team belongs to
- `belongsTo(Venue)` - Home venue for the team
- `belongsTo(User, 'captain_id')` - Team captain
- `belongsToMany(Player)` - Team roster (many-to-many)
- `hasOne(Rank)` - Current season ranking
- `hasMany(Game)` - Games played

**Key Attributes:**

- `name`: Team name
- `logo`: Team logo file path
- `captain_id`: User ID of team captain
- `venue_id`: Home venue ID
- `season_id`: Current season ID

**Key Methods:**

- `currentRank()`: Get team's current ranking
- `winPercentage()`: Calculate win percentage
- `homeGames()`: Get games where team is home
- `awayGames()`: Get games where team is away

### Player

Represents an individual player.

**File**: `app/Models/Player.php`

**Key Relationships:**

- `belongsTo(User)` - Associated user account
- `belongsToMany(Team)` - Teams the player belongs to
- `hasMany(Game)` - Games played

**Key Attributes:**

- `name`: Player name
- `photo`: Player photo file path
- `active`: Boolean indicating active status
- `user_id`: Associated user ID

**Key Methods:**

- `totalGames()`: Count of games played
- `wins()`: Count of games won
- `losses()`: Count of games lost
- `winPercentage()`: Calculate win percentage

### Venue

Represents a physical location where games are played.

**File**: `app/Models/Venue.php`

**Key Relationships:**

- `hasMany(Team)` - Teams with this as home venue
- `hasMany(Date)` - Game dates at this venue

**Key Attributes:**

- `name`: Venue name
- `address`: Physical address
- `contact`: Contact information
- `capacity`: Number of tables

### Date

Represents a scheduled game date.

**File**: `app/Models/Date.php`

**Key Relationships:**

- `belongsTo(Season)` - Season this date belongs to
- `belongsTo(Venue)` - Venue for games
- `hasMany(Schedule)` - Team matchups for this date
- `hasMany(Game)` - Individual games on this date

**Key Attributes:**

- `date`: Game date
- `time`: Game time
- `status`: Status (scheduled, in_progress, completed)
- `season_id`: Season ID
- `venue_id`: Venue ID

**Key Methods:**

- `isToday()`: Check if date is today
- `isPast()`: Check if date has passed
- `isFuture()`: Check if date is in future

### Game

Represents an individual game (match).

**File**: `app/Models/Game.php`

**Key Relationships:**

- `belongsTo(Date)` - Game date
- `belongsTo(Team, 'team_home_id')` - Home team
- `belongsTo(Team, 'team_away_id')` - Away team
- `belongsTo(Format)` - Game format (singles/doubles)
- `belongsTo(Player, 'player1_id')` - First player
- `belongsTo(Player, 'player2_id')` - Second player (doubles)

**Key Attributes:**

- `team_home_id`: Home team ID
- `team_away_id`: Away team ID
- `score_home`: Home team score
- `score_away`: Away team score
- `won_by`: Team ID of winner
- `game_number`: Game number in the match (1-15)
- `format_id`: Format ID

**Key Methods:**

- `winner()`: Get winning team
- `loser()`: Get losing team
- `isComplete()`: Check if game is finished
- `isSingles()`: Check if singles format
- `isDoubles()`: Check if doubles format

### Schedule

Represents a matchup between two teams on a date.

**File**: `app/Models/Schedule.php`

**Key Relationships:**

- `belongsTo(Date)` - Game date
- `belongsTo(Team, 'team_home_id')` - Home team
- `belongsTo(Team, 'team_away_id')` - Away team
- `hasMany(Game)` - Games in this matchup

**Key Attributes:**

- `date_id`: Game date ID
- `team_home_id`: Home team ID
- `team_away_id`: Away team ID

### Rank

Represents team ranking and statistics.

**File**: `app/Models/Rank.php`

**Key Relationships:**

- `belongsTo(Team)` - Team being ranked
- `belongsTo(Season)` - Season for ranking

**Key Attributes:**

- `team_id`: Team ID
- `season_id`: Season ID
- `points`: Total points earned
- `games_won`: Number of games won
- `games_lost`: Number of games lost
- `position`: Current ranking position

**Key Methods:**

- `winPercentage()`: Calculate win percentage
- `totalGames()`: Total games played

### Format

Represents game format (singles, doubles).

**File**: `app/Models/Format.php`

**Key Relationships:**

- `hasMany(Game)` - Games using this format

**Key Attributes:**

- `name`: Format name (Singles, Doubles)
- `description`: Format description
- `rules`: Format-specific rules

### Event

Represents special events and milestones.

**File**: `app/Models/Event.php`

**Key Attributes:**

- `title`: Event title
- `description`: Event description
- `date`: Event date
- `type`: Event type (tournament, milestone, etc.)

## Community Models

### Forum Models

**ForumCategory**: Forum discussion categories
**ForumThread**: Discussion threads
**ForumPost**: Individual posts in threads

### Chat Models

**ChatRoom**: Chat rooms for team/private communication
**ChatMessage**: Individual chat messages

## Data Integrity

### Soft Deletes

Most models use soft deletes to maintain data integrity:

```php
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;
}
```

When a record is "deleted," it's marked with a `deleted_at` timestamp instead of being removed from the database.

### Foreign Key Constraints

Relationships are enforced at the database level:

```php
Schema::create('teams', function (Blueprint $table) {
    $table->id();
    $table->foreignId('season_id')->constrained()->cascadeOnDelete();
    $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
    $table->foreignId('captain_id')->constrained('users')->cascadeOnDelete();
    // ...
});
```

### Timestamps

All models track creation and modification times:

```php
$table->timestamps(); // Adds created_at and updated_at
```

## Querying Patterns

### Eager Loading

Always eager load relationships to avoid N+1 queries:

❌ Bad:

```php
$teams = Team::all();
foreach ($teams as $team) {
    echo $team->captain->name; // N+1 query
}
```

✅ Good:

```php
$teams = Team::with('captain')->get();
foreach ($teams as $team) {
    echo $team->captain->name; // Single query
}
```

### Query Scopes

Use query scopes for reusable query logic:

```php
class Team extends Model
{
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeInSeason($query, Season $season)
    {
        return $query->where('season_id', $season->id);
    }
}

// Usage
$teams = Team::active()->inSeason($currentSeason)->get();
```

### Attribute Accessors

Use accessors for computed properties:

```php
class Player extends Model
{
    public function getWinPercentageAttribute(): float
    {
        $total = $this->games()->count();
        if ($total === 0) {
            return 0;
        }

        $wins = $this->games()->where('won_by', '!=', null)->count();
        return ($wins / $total) * 100;
    }
}

// Usage
$percentage = $player->win_percentage;
```

## Database Migrations

Migrations are version-controlled and run in sequence:

```bash
php artisan migrate              # Run pending migrations
php artisan migrate:rollback     # Rollback last batch
php artisan migrate:fresh        # Drop all tables and re-migrate
php artisan migrate:fresh --seed # Re-migrate and seed data
```

### Migration Best Practices

1. **Never modify existing migrations** - Create new ones instead
2. **Use descriptive names** - `create_teams_table`, `add_captain_to_teams`
3. **Always provide rollback** - Implement the `down()` method
4. **Use foreign keys** - Enforce referential integrity
5. **Index frequently queried columns** - Improve query performance

Example migration:

```php
public function up(): void
{
    Schema::create('teams', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('logo')->nullable();
        $table->foreignId('season_id')->constrained()->cascadeOnDelete();
        $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
        $table->foreignId('captain_id')->constrained('users')->cascadeOnDelete();
        $table->timestamps();
        $table->softDeletes();

        // Indexes
        $table->index('season_id');
        $table->index('venue_id');
        $table->index('captain_id');
    });
}

public function down(): void
{
    Schema::dropIfExists('teams');
}
```

## Seeders

Seeders populate the database with test data:

```bash
php artisan db:seed              # Run DatabaseSeeder
php artisan db:seed --class=TeamSeeder  # Run specific seeder
```

### Seeder Best Practices

1. **Use factories** - Generate realistic test data
2. **Make idempotent** - Safe to run multiple times
3. **Separate by concern** - One seeder per model/feature
4. **Use in tests** - Consistent test data

Example seeder:

```php
class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $season = Season::factory()->create(['active' => true]);
        $venue = Venue::factory()->create();

        Team::factory()
            ->count(10)
            ->for($season)
            ->for($venue)
            ->create();
    }
}
```

## Performance Considerations

### Indexing Strategy

Key indexes for optimal performance:

- Foreign keys (automatic with `constrained()`)
- Frequently filtered columns (`active`, `status`)
- Unique constraints (`email`, `name` + `season_id`)
- Composite indexes for multi-column queries

### Query Optimization

1. **Select only needed columns**: `select('id', 'name')`
2. **Use pagination**: `paginate(15)` instead of `get()`
3. **Cache expensive queries**: Use Redis for rankings
4. **Use database transactions**: For multi-step operations
5. **Avoid N+1 queries**: Always eager load relationships

## Backup Strategy

The application uses `spatie/laravel-backup` for automated backups:

- Daily database snapshots
- Weekly full backups including files
- S3 storage for backup retention
- Automatic old backup cleanup

## References

- [Laravel Database Documentation](https://laravel.com/docs/database)
- [Eloquent ORM Documentation](https://laravel.com/docs/eloquent)
- [Database Migrations](https://laravel.com/docs/migrations)
- [Database Seeding](https://laravel.com/docs/seeding)
