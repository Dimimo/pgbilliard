# Development Workflows

## Overview

This document describes common development workflows and tasks for the Puerto Galera Billiard League application.

## Daily Development

### Starting Your Development Environment

```bash
# Pull latest changes
git pull

# Install any new dependencies
composer install
npm install

# Run migrations if needed
php artisan migrate

# Start development servers (in separate terminals)
php artisan serve
php artisan reverb:start --debug
npm run dev

# Start queue worker if needed
php artisan queue:work
```

### Stopping Your Environment

```bash
# Stop servers with Ctrl+C in each terminal
# Or if using Sail:
sail down
```

## Working with Database

### Creating Migrations

Create a new migration file:

```bash
# Create table
php artisan make:migration create_table_name_table

# Add column
php artisan make:migration add_column_to_table_name_table

# Modify table
php artisan make:migration modify_table_name_table
```

Migration file structure:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
```

Run migrations:

```bash
php artisan migrate
```

### Rolling Back Migrations

```bash
# Rollback last batch
php artisan migrate:rollback

# Rollback last 5 batches
php artisan migrate:rollback --step=5

# Rollback all migrations
php artisan migrate:reset

# Drop all tables and re-migrate
php artisan migrate:fresh

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

### Creating Seeders

Create a seeder:

```bash
php artisan make:seeder TeamSeeder
```

Seeder structure:

```php
<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::factory()->count(10)->create();
    }
}
```

Run seeders:

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=TeamSeeder
```

### Creating Factories

Create a factory:

```bash
php artisan make:factory TeamFactory
```

Factory structure:

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'logo' => null,
            'season_id' => Season::factory(),
            'venue_id' => Venue::factory(),
            'captain_id' => User::factory(),
        ];
    }
}
```

## Working with Models

### Creating Models

Create a model:

```bash
# Just model
php artisan make:model Team

# Model with migration
php artisan make:model Team -m

# Model with migration, factory, and seeder
php artisan make:model Team -mfs

# Model with migration, factory, seeder, and controller
php artisan make:model Team -mfsc
```

Model structure:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'season_id',
        'venue_id',
        'captain_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class);
    }

    // Accessors
    public function getWinPercentageAttribute(): float
    {
        // Calculation logic
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
```

### Creating Policies

Create a policy:

```bash
php artisan make:policy TeamPolicy --model=Team
```

Policy structure:

```php
<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;

class TeamPolicy
{
    public function view(User $user, Team $team): bool
    {
        return true;
    }

    public function update(User $user, Team $team): bool
    {
        return $user->isAdmin() || $user->id === $team->captain_id;
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->isAdmin();
    }
}
```

Register policies in `app/Providers/AuthServiceProvider.php`:

```php
protected $policies = [
    Team::class => TeamPolicy::class,
];
```

## Working with Livewire Components

### Creating Livewire Components

Create a Livewire component:

```bash
# Basic component
php artisan make:livewire TeamList

# Component in subdirectory
php artisan make:livewire Team/CreateTeam

# Inline component (single file)
php artisan make:livewire TeamList --inline
```

Component class structure:

```php
<?php

namespace App\Livewire\Team;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;

class TeamList extends Component
{
    use WithPagination;

    public string $search = '';

    protected $queryString = ['search'];

    public function render()
    {
        return view('livewire.team.team-list', [
            'teams' => Team::query()
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->paginate(15),
        ]);
    }
}
```

Component view structure:

```blade
<div>
    <input type="text" wire:model.live="search" placeholder="Search teams...">

    <div class="grid gap-4">
        @foreach($teams as $team)
            <div class="card">
                <h3>{{ $team->name }}</h3>
            </div>
        @endforeach
    </div>

    {{ $teams->links() }}
</div>
```

### Form Components

Create a form component:

```php
<?php

namespace App\Livewire\Team;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTeam extends Component
{
    use WithFileUploads;

    public string $name = '';
    public $logo;
    public int $venue_id;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:teams',
            'logo' => 'nullable|image|max:1024',
            'venue_id' => 'required|exists:venues,id',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->logo) {
            $validated['logo'] = $this->logo->store('logos', 'public');
        }

        Team::create($validated);

        session()->flash('message', 'Team created successfully.');

        return redirect()->route('teams.index');
    }

    public function render()
    {
        return view('livewire.team.create-team');
    }
}
```

### Real-time Updates

Implement real-time updates:

```php
<?php

namespace App\Livewire\Game;

use App\Models\Game;
use Livewire\Component;
use Livewire\Attributes\On;

class GameScore extends Component
{
    public Game $game;

    #[On('score-updated')]
    public function refreshGame()
    {
        $this->game->refresh();
    }

    public function updateScore(int $homeScore, int $awayScore)
    {
        $this->game->update([
            'score_home' => $homeScore,
            'score_away' => $awayScore,
        ]);

        $this->dispatch('score-updated');
    }

    public function render()
    {
        return view('livewire.game.game-score');
    }
}
```

## Working with Events and Broadcasting

### Creating Events

Create an event:

```bash
php artisan make:event ScoreUpdated
```

Event structure:

```php
<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoreUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Game $game)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('games.' . $this->game->id);
    }

    public function broadcastWith(): array
    {
        return [
            'game_id' => $this->game->id,
            'score_home' => $this->game->score_home,
            'score_away' => $this->game->score_away,
        ];
    }
}
```

Dispatch the event:

```php
event(new ScoreUpdated($game));
```

Listen to the event in JavaScript:

```javascript
Echo.channel(`games.${gameId}`)
    .listen('ScoreUpdated', (e) => {
        console.log('Score updated:', e);
        // Update UI
    });
```

### Creating Listeners

Create a listener:

```bash
php artisan make:listener UpdateRankings --event=ScoreUpdated
```

Listener structure:

```php
<?php

namespace App\Listeners;

use App\Events\ScoreUpdated;

class UpdateRankings
{
    public function handle(ScoreUpdated $event): void
    {
        // Update team rankings
        $event->game->teamHome->updateRanking();
        $event->game->teamAway->updateRanking();
    }
}
```

Register event and listener in `app/Providers/EventServiceProvider.php`:

```php
protected $listen = [
    ScoreUpdated::class => [
        UpdateRankings::class,
        BroadcastScoreUpdate::class,
    ],
];
```

## Working with Jobs

### Creating Jobs

Create a job:

```bash
php artisan make:job ProcessGameStatistics
```

Job structure:

```php
<?php

namespace App\Jobs;

use App\Models\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessGameStatistics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Game $game)
    {
    }

    public function handle(): void
    {
        // Process game statistics
        $this->game->calculateStatistics();
    }
}
```

Dispatch the job:

```php
// Dispatch immediately
ProcessGameStatistics::dispatch($game);

// Dispatch after delay
ProcessGameStatistics::dispatch($game)->delay(now()->addMinutes(5));

// Dispatch to specific queue
ProcessGameStatistics::dispatch($game)->onQueue('statistics');
```

## Frontend Development

### Working with Tailwind CSS

Build CSS:

```bash
# Development mode with watch
npm run dev

# Production build
npm run build
```

Custom Tailwind configuration in `tailwind.config.js`:

```javascript
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/Livewire/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#1e40af',
            },
        },
    },
    plugins: [],
};
```

### Working with Alpine.js

Alpine.js is included for interactive components:

```blade
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>

    <div x-show="open" x-transition>
        Content
    </div>
</div>
```

## Code Quality

### Running Laravel Pint

Fix code style issues:

```bash
./vendor/bin/pint

# Check without fixing
./vendor/bin/pint --test

# Fix specific files
./vendor/bin/pint app/Models/Team.php
```

### Running Larastan

Static analysis:

```bash
./vendor/bin/phpstan analyse

# With baseline (ignoring existing issues)
./vendor/bin/phpstan analyse --generate-baseline
```

### Running Rector

Automated code refactoring:

```bash
./vendor/bin/rector process

# Dry run (see changes without applying)
./vendor/bin/rector process --dry-run
```

## Debugging

### Using Tinker

Interactive REPL for Laravel:

```bash
php artisan tinker
```

Example commands:

```php
// Query database
User::count()
Team::with('players')->first()

// Test relationships
$team = Team::find(1)
$team->players

// Execute code
event(new ScoreUpdated(Game::first()))
```

### Using Debugbar

Laravel Debugbar provides detailed debugging information. It's automatically enabled when `APP_DEBUG=true`.

Key features:

- SQL query logging with execution time
- View data inspection
- Route information
- Request/response details

### Logging

Add log statements:

```php
use Illuminate\Support\Facades\Log;

Log::debug('Debug message', ['data' => $data]);
Log::info('Info message');
Log::warning('Warning message');
Log::error('Error message', ['exception' => $e]);
```

View logs:

```bash
tail -f storage/logs/laravel.log
```

## Common Tasks

### Clearing Caches

```bash
# Clear application cache
php artisan cache:clear

# Clear route cache
php artisan route:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear

# Clear all caches
php artisan optimize:clear
```

### Optimizing for Production

```bash
# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Run all optimizations
php artisan optimize
```

### Generating Documentation

Generate API documentation:

```bash
php artisan scribe:generate
```

### Creating Backups

Manual backup:

```bash
php artisan backup:run
```

List backups:

```bash
php artisan backup:list
```

## Git Workflow

### Daily Workflow

```bash
# Pull latest changes
git pull

# Make your changes
# ... edit files ...

# Check status
git status

# View changes
git diff

# Stage changes
git add .

# Commit with descriptive message
git commit -m "Add feature: team roster management"

# Push to main
git push origin main
```

### Commit Message Guidelines

Follow these conventions:

- **Add**: New features (`Add player statistics page`)
- **Update**: Changes to existing features (`Update team ranking algorithm`)
- **Fix**: Bug fixes (`Fix score calculation error`)
- **Refactor**: Code improvements (`Refactor game scoring logic`)
- **Remove**: Deleted code/features (`Remove deprecated API endpoints`)
- **Docs**: Documentation changes (`Update installation guide`)

## Next Steps

- Review [Testing](03-testing.md) for testing workflows
- Check [Deployment Guide](../03-deployment/README.md) for production deployment
