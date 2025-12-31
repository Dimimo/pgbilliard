# Testing

## Overview

The Puerto Galera Billiard League application uses Pest PHP as its testing framework. This document covers testing strategies, writing tests, and running test suites.

## Testing Stack

- **Pest PHP 3**: Modern testing framework for PHP
- **PHPUnit 11**: Underlying test runner
- **Laravel Testing Utilities**: Laravel's testing helpers
- **Pest Laravel Plugin**: Laravel-specific Pest features

## Test Structure

Tests are organized in the `tests` directory:

```text
tests/
├── Feature/          # Feature tests (end-to-end)
│   ├── Auth/
│   ├── Team/
│   ├── Game/
│   └── ...
├── Unit/             # Unit tests (isolated)
│   ├── Models/
│   ├── Services/
│   └── ...
├── Pest.php          # Pest configuration
└── TestCase.php      # Base test case
```

## Running Tests

### Run All Tests

```bash
php artisan test
```

Or using Pest directly:

```bash
./vendor/bin/pest
```

### Run Specific Test Files

```bash
# Run specific file
php artisan test tests/Feature/Team/TeamManagementTest.php

# Using Pest
./vendor/bin/pest tests/Feature/Team/TeamManagementTest.php
```

### Run Tests by Filter

```bash
# Run tests matching pattern
php artisan test --filter team

# Run specific test
php artisan test --filter "can create team"
```

### Run with Coverage

```bash
php artisan test --coverage

# With coverage threshold
php artisan test --coverage --min=80
```

### Parallel Testing

Run tests in parallel for faster execution:

```bash
php artisan test --parallel
```

## Writing Tests

### Feature Tests

Feature tests test complete user workflows and HTTP interactions.

#### Example: Team Management Test

```php
<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Venue;
use App\Models\Season;

test('authenticated user can view teams list', function () {
    $user = User::factory()->create();

    Team::factory()->count(3)->create();

    $this->actingAs($user)
        ->get(route('teams.index'))
        ->assertOk()
        ->assertViewIs('teams.index')
        ->assertViewHas('teams');
});

test('captain can create a team', function () {
    $captain = User::factory()->create();
    $venue = Venue::factory()->create();
    $season = Season::factory()->create(['active' => true]);

    $teamData = [
        'name' => 'Test Team',
        'venue_id' => $venue->id,
        'season_id' => $season->id,
    ];

    $this->actingAs($captain)
        ->post(route('teams.store'), $teamData)
        ->assertRedirect(route('teams.index'))
        ->assertSessionHas('message', 'Team created successfully.');

    $this->assertDatabaseHas('teams', [
        'name' => 'Test Team',
        'captain_id' => $captain->id,
    ]);
});

test('captain can update their team', function () {
    $captain = User::factory()->create();
    $team = Team::factory()->create(['captain_id' => $captain->id]);

    $updatedData = ['name' => 'Updated Team Name'];

    $this->actingAs($captain)
        ->put(route('teams.update', $team), $updatedData)
        ->assertRedirect()
        ->assertSessionHas('message');

    expect($team->fresh()->name)->toBe('Updated Team Name');
});

test('non-captain cannot update team', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $this->actingAs($user)
        ->put(route('teams.update', $team), ['name' => 'Hacked Name'])
        ->assertForbidden();
});

test('team name must be unique', function () {
    $captain = User::factory()->create();
    Team::factory()->create(['name' => 'Existing Team']);

    $this->actingAs($captain)
        ->post(route('teams.store'), ['name' => 'Existing Team'])
        ->assertSessionHasErrors(['name']);
});
```

#### Example: Livewire Component Test

```php
<?php

use App\Livewire\Team\CreateTeam;
use App\Models\User;
use App\Models\Venue;
use Livewire\Livewire;

test('create team component can be rendered', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(CreateTeam::class)
        ->assertStatus(200);
});

test('team can be created through livewire component', function () {
    $user = User::factory()->create();
    $venue = Venue::factory()->create();

    $this->actingAs($user);

    Livewire::test(CreateTeam::class)
        ->set('name', 'New Team')
        ->set('venue_id', $venue->id)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('teams.index'));

    $this->assertDatabaseHas('teams', [
        'name' => 'New Team',
        'captain_id' => $user->id,
    ]);
});

test('team name is required', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test(CreateTeam::class)
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

test('team component updates in real-time', function () {
    $user = User::factory()->create();
    $team = Team::factory()->create();

    $this->actingAs($user);

    Livewire::test(EditTeam::class, ['team' => $team])
        ->set('name', 'Updated Name')
        ->assertSet('name', 'Updated Name')
        ->call('save')
        ->assertHasNoErrors()
        ->assertDispatched('team-updated');
});
```

### Unit Tests

Unit tests focus on testing individual methods and classes in isolation.

#### Example: Model Tests

```php
<?php

use App\Models\Player;
use App\Models\Game;
use App\Models\Team;

test('player win percentage is calculated correctly', function () {
    $player = Player::factory()->create();

    // Create 7 wins
    Game::factory()->count(7)->create([
        'player1_id' => $player->id,
        'won_by' => fn() => $player->team_id,
    ]);

    // Create 3 losses
    Game::factory()->count(3)->create([
        'player1_id' => $player->id,
        'won_by' => fn() => Team::factory()->create()->id,
    ]);

    expect($player->fresh()->win_percentage)->toBe(70.0);
});

test('player with no games has zero win percentage', function () {
    $player = Player::factory()->create();

    expect($player->win_percentage)->toBe(0.0);
});

test('team ranking is updated after game', function () {
    $team = Team::factory()->create();
    $rank = $team->rank()->create(['points' => 0]);

    $game = Game::factory()->create([
        'team_home_id' => $team->id,
        'won_by' => $team->id,
    ]);

    $team->updateRanking();

    expect($rank->fresh()->points)->toBeGreaterThan(0);
});

test('soft deleted teams are excluded from rankings', function () {
    $activeTeam = Team::factory()->create();
    $deletedTeam = Team::factory()->create();

    $deletedTeam->delete();

    $teams = Team::all();

    expect($teams)->toHaveCount(1)
        ->and($teams->first()->id)->toBe($activeTeam->id);
});
```

#### Example: Service/Logic Tests

```php
<?php

use App\Services\RankingService;
use App\Models\Team;
use App\Models\Season;

test('ranking service calculates team positions correctly', function () {
    $season = Season::factory()->create();

    $team1 = Team::factory()->create();
    $team1->rank()->create(['points' => 30, 'season_id' => $season->id]);

    $team2 = Team::factory()->create();
    $team2->rank()->create(['points' => 20, 'season_id' => $season->id]);

    $team3 = Team::factory()->create();
    $team3->rank()->create(['points' => 25, 'season_id' => $season->id]);

    $service = new RankingService();
    $service->updatePositions($season);

    expect($team1->rank->fresh()->position)->toBe(1)
        ->and($team3->rank->fresh()->position)->toBe(2)
        ->and($team2->rank->fresh()->position)->toBe(3);
});

test('ranking service handles tied teams', function () {
    $season = Season::factory()->create();

    $team1 = Team::factory()->create();
    $team1->rank()->create(['points' => 30, 'games_won' => 15, 'season_id' => $season->id]);

    $team2 = Team::factory()->create();
    $team2->rank()->create(['points' => 30, 'games_won' => 12, 'season_id' => $season->id]);

    $service = new RankingService();
    $service->updatePositions($season);

    // Team with more wins should rank higher
    expect($team1->rank->fresh()->position)->toBeLessThan($team2->rank->fresh()->position);
});
```

## Testing Patterns

### Using Datasets

Pest allows testing with multiple datasets:

```php
test('team name validation', function (string $name, bool $shouldPass) {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('teams.store'), ['name' => $name]);

    if ($shouldPass) {
        $response->assertSessionHasNoErrors();
    } else {
        $response->assertSessionHasErrors(['name']);
    }
})->with([
    ['Valid Team', true],
    ['', false],
    [str_repeat('a', 256), false],
    ['Team with special !@#', true],
]);
```

### Setup and Teardown

Use `beforeEach` and `afterEach` for test setup:

```php
beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('user can view dashboard', function () {
    $this->get(route('dashboard'))
        ->assertOk();
});

test('user can view profile', function () {
    $this->get(route('profile'))
        ->assertOk();
});
```

### Using Custom Expectations

Define custom expectations for better readability:

```php
expect()->extend('toBeValidTeam', function () {
    return $this->toBeInstanceOf(Team::class)
        ->and($this->value->name)->not->toBeEmpty()
        ->and($this->value->captain_id)->not->toBeNull();
});

test('factory creates valid team', function () {
    $team = Team::factory()->create();

    expect($team)->toBeValidTeam();
});
```

### Testing Broadcasting

Test that events are broadcast:

```php
use Illuminate\Support\Facades\Event;
use App\Events\ScoreUpdated;

test('score update broadcasts event', function () {
    Event::fake([ScoreUpdated::class]);

    $game = Game::factory()->create();
    $game->update(['score_home' => 5]);

    Event::assertDispatched(ScoreUpdated::class, function ($event) use ($game) {
        return $event->game->id === $game->id;
    });
});
```

### Testing Jobs

Test that jobs are dispatched:

```php
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessGameStatistics;

test('game completion dispatches statistics job', function () {
    Queue::fake();

    $game = Game::factory()->create();
    $game->complete();

    Queue::assertPushed(ProcessGameStatistics::class, function ($job) use ($game) {
        return $job->game->id === $game->id;
    });
});
```

### Testing Mail

Test that emails are sent:

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\GameScheduled;

test('team captain receives game schedule email', function () {
    Mail::fake();

    $team = Team::factory()->create();
    $game = Game::factory()->create(['team_home_id' => $team->id]);

    Mail::assertSent(GameScheduled::class, function ($mail) use ($team) {
        return $mail->hasTo($team->captain->email);
    });
});
```

## Database Testing

### Using Transactions

By default, tests run in database transactions that are rolled back after each test.

```php
// In tests/TestCase.php
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
}
```

### Using In-Memory SQLite

For faster tests, use in-memory SQLite:

```php
// In phpunit.xml or .env.testing
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### Testing with Real Database

For integration tests that need the actual database:

```php
use Illuminate\Foundation\Testing\DatabaseTransactions;

test('complex query works correctly', function () {
    // This test uses real database with transactions
})->uses(DatabaseTransactions::class);
```

## Continuous Integration

### Running Tests in CI

Example GitHub Actions workflow:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ALLOW_EMPTY_PASSWORD: yes
          MYSQL_DATABASE: testing
        ports:
          - 3306:3306

      redis:
        image: redis:6
        ports:
          - 6379:6379

    steps:
      - uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: mbstring, pdo, pdo_mysql, redis

      - name: Install Composer Dependencies
        run: composer install --prefer-dist --no-interaction

      - name: Copy .env
        run: cp .env.testing .env

      - name: Generate Key
        run: php artisan key:generate

      - name: Run Tests
        run: php artisan test --parallel
```

## Test Coverage

### Generating Coverage Reports

```bash
# Terminal coverage report
php artisan test --coverage

# HTML coverage report
php artisan test --coverage-html coverage
```

Open `coverage/index.html` in your browser to view detailed coverage.

### Coverage Requirements

Set minimum coverage thresholds:

```bash
php artisan test --coverage --min=80
```

Or in `phpunit.xml`:

```xml
<coverage>
    <report>
        <html outputDirectory="coverage"/>
    </report>
</coverage>
```

## Best Practices

### 1. Test Organization

- **Feature tests**: Test user workflows and HTTP interactions
- **Unit tests**: Test individual methods and classes
- **Integration tests**: Test component interactions

### 2. Naming Conventions

Use descriptive test names that read like specifications:

✅ Good:

```php
test('captain can update their team name')
test('non-captain cannot delete team')
test('win percentage is calculated correctly')
```

❌ Bad:

```php
test('test1')
test('update team')
test('calculation')
```

### 3. Arrange-Act-Assert

Structure tests with clear sections:

```php
test('team ranking updates after win', function () {
    // Arrange
    $team = Team::factory()->create();
    $rank = $team->rank()->create(['points' => 0]);

    // Act
    $game = Game::factory()->create([
        'team_home_id' => $team->id,
        'won_by' => $team->id,
    ]);
    $team->updateRanking();

    // Assert
    expect($rank->fresh()->points)->toBeGreaterThan(0);
});
```

### 4. Don't Test Framework Code

Don't test Laravel's built-in functionality:

❌ Bad:

```php
test('belongsTo relationship works', function () {
    $team = Team::factory()->create();
    expect($team->season)->toBeInstanceOf(Season::class);
});
```

✅ Good:

```php
test('team correctly calculates season statistics', function () {
    $team = Team::factory()->create();
    // Test your business logic, not Eloquent
});
```

### 5. Use Factories

Always use factories instead of manual model creation:

❌ Bad:

```php
$team = Team::create([
    'name' => 'Test Team',
    'season_id' => 1,
    // ... many more fields
]);
```

✅ Good:

```php
$team = Team::factory()->create(['name' => 'Test Team']);
```

### 6. Keep Tests Fast

- Use in-memory SQLite when possible
- Mock external services
- Avoid unnecessary database queries
- Use `RefreshDatabase` judiciously

### 7. Test One Thing

Each test should verify one specific behavior:

❌ Bad:

```php
test('team management', function () {
    $team = Team::factory()->create();
    expect($team->name)->not->toBeEmpty();
    expect($team->players)->toBeEmpty();
    $team->update(['name' => 'New Name']);
    expect($team->name)->toBe('New Name');
    // Testing too many things
});
```

✅ Good:

```php
test('new team has no players', function () {
    $team = Team::factory()->create();
    expect($team->players)->toBeEmpty();
});

test('team name can be updated', function () {
    $team = Team::factory()->create();
    $team->update(['name' => 'New Name']);
    expect($team->name)->toBe('New Name');
});
```

## Debugging Tests

### Run Single Test

```bash
php artisan test --filter "can create team"
```

### View Test Output

```bash
# Show detailed output
php artisan test -v

# Show even more detail
php artisan test -vv
```

### Dump Data in Tests

```php
test('debugging example', function () {
    $team = Team::factory()->create();

    dump($team->toArray()); // Dump data
    dd($team); // Dump and die

    expect($team)->toBeInstanceOf(Team::class);
});
```

### Use Ray for Debugging

Install [Spatie Ray](https://myray.app/):

```php
test('debugging with ray', function () {
    $team = Team::factory()->create();

    ray($team); // Send data to Ray app

    expect($team)->toBeInstanceOf(Team::class);
});
```

## Resources

- [Pest PHP Documentation](https://pestphp.com)
- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [Livewire Testing Documentation](https://livewire.laravel.com/docs/testing)
