<?php

use Illuminate\Support\Facades\Route;

/**
 * A bit of a strange fix to make sure the routes are recognized by the IDE
 */
Route::get('/', fn () => view('pages.index'))->name('scoreboard');
Route::get('rank', fn () => view('pages.rank'))->name('rank');
Route::get('calendar', fn () => view('pages.calendar'))->name('calendar');
Route::get('seasons', fn () => view('pages.seasons.all'))->name('seasons');
Route::get('logs', fn () => view('pages.logs'))->name('logs');
Route::get('privacy-policy', fn () => view('pages.privacy-policy'))->name('privacy-policy');

Route::get('dates/show/{date}', fn ($date) => view('pages.dates.show.[Date]', [
    'date' => \App\Models\Date::query()->find($date)
]))->name('dates.show');

Route::get('players/show/{player}', fn ($player) => view('pages.players.show.[Player]', [
    'player' => \App\Models\Player::query()->find($player)
]))->name('players.show');

Route::get('schedule/event/{event}', fn ($event) => view('pages.schedule.event.[Event]', [
    'event' => \App\Models\Event::query()->find($event)
]))->name('schedule.event');

/**
 * Routes for TEAMS
 */
Route::prefix('team')->group(function (): void {
    Route::get('/', fn () => view('pages.teams.index'))->name('teams.index');
    Route::get('show/{team}', fn ($team) => view('pages.teams.show.[Team]', [
        'team' => \App\Models\Team::query()->find($team)
    ]))->name('teams.show');
    Route::get('edit/{team}', fn ($team) => view('pages.teams.edit.[Team]', [
        'team' => \App\Models\Team::query()->find($team)
    ]))->name('teams.edit');
});

/**
 * Routes for VENUES
 */
Route::prefix('venues')->group(function (): void {
    Route::get('show/{venue}', fn ($venue) => view('pages.venues.show.[Venue]', [
        'venue' => \App\Models\Venue::query()->find($venue)
    ]))->name('venues.show');
    Route::get('edit/{venue}', fn ($venue) => view('pages.venues.edit.[Venue]', [
        'venue' => \App\Models\Venue::query()->find($venue)
    ]))->name('venues.edit');
});

/**
 * Routes for ADMIN
 */
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function (): void {
    Route::get('/', fn () => view('pages.admin.index'))->name('admin.index');
    Route::get('overview', fn () => view('pages.admin.overview'))->name('admin.overview');
    Route::get('contact', fn () => view('pages.admin.contact'))->name('admin.contact');
    Route::get('players/overview', fn () => view('pages.admin.players.overview'))->name('admin.players.overview');
    Route::get('teams/create', fn () => view('pages.admin.teams.create'))->name('admin.teams.create');
    Route::get('venues/create', fn () => view('pages.admin.venues.create'))->name('admin.venues.create');

    Route::prefix('calendar')->group(function (): void {
        Route::get('create/{season}', fn ($season) => view('pages.admin.calendar.create.[Season]', [
            'season' => \App\Models\Season::query()->find($season)
        ]))->name('admin.calendar.create');
        Route::get('update/{season}', fn ($season) => view('pages.admin.calendar.update.[Season]', [
            'season' => \App\Models\Season::query()->find($season)
        ]))->name('admin.calendar.update');
        Route::get('shift/{season}', fn ($season) => view('pages.admin.calendar.shift.[Season]', [
            'season' => \App\Models\Season::query()->find($season)
        ]))->name('admin.calendar.shift');
    });

    Route::prefix('schedule')->group(function (): void {
        Route::get('/', fn () => view('pages.admin.schedule.index'))->name('admin.schedule.index');
        Route::get('create', fn () => view('pages.admin.schedule.create'))->name('admin.schedule.create');
        Route::get('update/{format}', fn ($format) => view('pages.admin.schedule.update.[Format]', [
            'format' => \App\Models\Format::query()->find($format)
        ]))->name('admin.schedule.update');
    });

    Route::prefix('season')->group(function (): void {
        Route::get('create', fn () => view('pages.admin.seasons.create'))->name('admin.seasons.create');
        Route::get('update/{season}', fn ($season) => view('pages.admin.seasons.update.[Season]', [
            'season' => \App\Models\Season::query()->find($season)
        ]))->name('admin.seasons.update');
    });
}); // end routes for ADMIN

/**
 * Routes for FORUM
 */
Route::prefix('forum')->group(function (): void {
    Route::prefix('posts')->group(function (): void {
        Route::get('/', fn () => view('pages.forum.posts.index'))->name('forum.posts.index');
        Route::get('create', fn () => view('pages.forum.posts.create'))->name('forum.posts.create');
        Route::get('show/{post}', fn ($post) => view('pages.forum.posts.show.[Post]', [
            'post' => \App\Models\Forum\Post::query()->find($post)
        ]))->name('forum.posts.show');
        Route::get('edit/{post}', fn ($post) => view('pages.forum.posts.edit.[Post]', [
            'post' => \App\Models\Forum\Post::query()->find($post)
        ]))->name('forum.posts.edit');
        Route::get('create', fn () => view('pages.forum.posts.create'))->name('forum.posts.create');
    });
    Route::prefix('comments')->group(function (): void {
        Route::get('create/{post}', fn ($post) => view('pages.forum.comments.create.[Post]', [
            'post' => \App\Models\Forum\Post::query()->find($post)
        ]))->name('forum.comments.create');
        Route::get('edit/{comment}', fn ($comment) => view('pages.forum.comments.edit.[Comment]', [
            'comment' => \App\Models\Forum\Comment::query()->find($comment)
        ]))->name('forum.comments.edit');
    });
});

/**
 * Routes for the CHAT
 */
Route::prefix('chat')->group(function (): void {
    Route::get('/', fn () => view('pages.chat.index'))->name('chat.index');
    Route::get('create', fn () => view('pages.chat.create'))->name('chat.room.create');
    Route::get('{room}', fn ($room) => view('pages.chat.[.App.Models.Chat.ChatRoom]', [
        'room' => \App\Models\Chat\ChatRoom::query()->find($room)
    ]))->name('chat.room');
    Route::get('edit/{room}', fn ($room) => view('pages.chat.edit.[.App.Models.Chat.ChatRoom.]', [
        'room' => \App\Models\Chat\ChatRoom::query()->find($room)
    ]))->name('chat.room.edit');
});

Route::middleware('auth')->group(function (): void {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
});

// authentification
Route::middleware('guest')->group(function (): void {
    Route::get('login', fn () => view('pages.auth.login'))->name('login');
    Route::get('register', fn () => view('pages.auth.register'))->name('register');
    Route::get('forgot-password', fn () => view('pages.auth.forgot-password'))->name('password.request');
    Route::get('players/accounts', fn () => view('pages.players.accounts'))->name('players.accounts');
});

/**
 * Route for the schedule download
 */
Route::get('schedule/original', fn () => response()->download(public_path('day-schedule.pdf')))->name('schedule.original');
Route::get('schedule/new', fn () => response()->download(public_path('reviewed_day_schedule.pdf')))->name('schedule.new');

/**
 * Routes for the help files
 */
Route::prefix('help')->group(function (): void {
    Route::get('billiard-rules', fn () => view('pages.help.billiard-rules'))->name('help.rules');
    Route::get('calendar', fn () => view('pages.help.calendar'))->name('help.calendar');
    Route::get('changelog', fn () => view('pages.help.changelog'))->name('help.changelog');
    Route::get('chat', fn () => view('pages.help.chat'))->name('help.chat');
    Route::get('competition-results', fn () => view('pages.help.competition-results'))->name('help.results');
    Route::get('google-play', fn () => view('pages.help.google-play'))->name('help.google-play');
    Route::get('live-scores', fn () => view('pages.help.live-scores'))->name('help.live-scores');
    Route::get('ranking', fn () => view('pages.help.ranking'))->name('help.ranking');
    Route::get('schedule', fn () => view('pages.help.schedule'))->name('help.schedule');
    Route::get('teams', fn () => view('pages.help.teams'))->name('help.teams');
});

Route::prefix('admin/help')->middleware('auth')->group(function (): void {
    Route::get('calendar', fn () => view('pages.admin.help.calendar'))->name('admin.help.calendar');
    Route::get('overview', fn () => view('pages.admin.help.overview'))->name('admin.help.overview');
    Route::get('schedule', fn () => view('pages.admin.help.schedule'))->name('admin.help.schedule');
    Route::get('season-structure', fn () => view('pages.admin.help.season-structure'))->name('admin.help.structure');
    Route::get('players', fn () => view('pages.admin.help.players'))->name('admin.help.players');
});

//Route for Testing
Route::middleware(['auth', 'admin'])->get('justfortesting', fn () => view('pages.test'));


/**
 * Mail routes to test the email body
 */
Route::prefix('mailable')->group(function (): void {
    Route::get('date/{date}', function ($date) {
        $date = \App\Models\Date::query()->find($date);
        return new \App\Mail\DayScoresConfirmed($date);
    });

    Route::get('date/{date}/admin', function ($date) {
        $date = \App\Models\Date::query()->find($date);
        $send_to = ['Joe Doe', 'Jane Doe'];
        return new \App\Mail\DayScoresToAdmin($date, \Illuminate\Support\Arr::sort($send_to));
    });

    Route::get('account-claimed/{user}', function ($user) {
        $user = \App\Models\User::query()->find($user);
        return new \App\Mail\AccountClaimed($user, "The email has been changed");
    });

    Route::get('email-changed', fn () => new \App\Mail\EmailChanged());

    Route::get('captain-reminder/{user}', function ($user) {
        $user = \App\Models\User::query()->find($user);
        return new \App\Mail\RemindCaptainOfNewUser($user);
    });

    Route::get('contact-players', function () {
        $subject = "A simple test";
        $body = "The body content\nwith a new line";
        return new \App\Mail\ContactPlayers($subject, $body);
    });

    // try with /mailable/game-reminder/300/240
    Route::get('game-reminder/{date}/{team}', function ($date, $team) {
        $date = \App\Models\Date::query()->find($date);
        $team = \App\Models\Team::query()->find($team);
        return new \App\Mail\PlayDayEmailReminder($date, $team);
    });
});

require __DIR__ . '/auth.php';
