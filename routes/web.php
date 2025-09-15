<?php

use Illuminate\Support\Facades\Route;

/**
 * A bit of a strange fix to make sure the routes are recognized by the IDE
 */
Route::middleware('detect.android')->get('/', fn () => view('pages.index'))->name('scoreboard');
Route::get('rank', fn () => view('pages.rank'))->name('rank');
Route::get('calendar', fn () => view('pages.calendar'))->name('calendar');
Route::get('seasons', fn () => view('pages.seasons.all'))->name('seasons');
Route::get('logs', fn () => view('pages.logs'))->name('logs');
Route::get('privacy-policy', fn () => view('pages.privacy-policy'))->name('privacy-policy');

Route::get('teams', fn () => view('pages.teams.index'))->name('teams.index');
Route::get('teams/show/{team}', fn ($team) => view('pages.teams.show.[Team]', [
    'team' => \App\Models\Team::find($team)
]))->name('teams.show');
Route::get('teams/edit/{team}', fn ($team) => view('pages.teams.edit.[Team]', [
    'team' => \App\Models\Team::find($team)
]))->name('teams.edit');

Route::get('venues/show/{venue}', fn ($venue) => view('pages.venues.show.[Venue]', [
    'venue' => \App\Models\Venue::find($venue)
]))->name('venues.show');
Route::get('venues/edit/{venue}', fn ($venue) => view('pages.venues.edit.[Venue]', [
    'venue' => \App\Models\Venue::find($venue)
]))->name('venues.edit');

Route::get('dates/show/{date}', fn ($date) => view('pages.dates.show.[Date]', [
    'date' => \App\Models\Date::find($date)
]))->name('dates.show');

Route::get('players/show/{player}', fn ($player) => view('pages.players.show.[Player]', [
    'player' => \App\Models\Player::find($player)
]))->name('players.show');

Route::get('schedule/event/{event}', fn ($event) => view('pages.schedule.event.[Event]', [
    'event' => \App\Models\Event::find($event)
]))->name('schedule.event');

Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    Route::view('profile', 'profile')
        ->name('profile');
});

/**
 * Route for the schedule download
 */
Route::get('schedule/new', function () {
    return response()->download(public_path('reviewed_day_schedule.pdf'));
})->name('schedule.new');

/**
 * Routes for the help files
 */
Route::prefix('help')->group(function () {
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

Route::prefix('admin/help')->group(function () {
    Route::get('calendar', fn () => view('pages.admin.help.calendar'))->name('admin.help.calendar');
    Route::get('overview', fn () => view('pages.admin.help.overview'))->name('admin.help.overview');
    Route::get('schedule', fn () => view('pages.admin.help.schedule'))->name('admin.help.schedule');
    Route::get('season-structure', fn () => view('pages.admin.help.season-structure'))->name('admin.help.structure');
});



/**
 * Mail routes to test the email body
 */
Route::prefix('mailable')->group(function () {
    Route::get('date/{date}', function ($date) {
        $date = \App\Models\Date::find($date);
        return new \App\Mail\DayScoresConfirmed($date);
    });

    Route::get('date/{date}/admin', function ($date) {
        $date = \App\Models\Date::find($date);
        $send_to = ['Joe Doe', 'Jane Doe'];
        return new \App\Mail\DayScoresToAdmin($date, \Arr::sort($send_to));
    });

    Route::get('account-claimed/{user}', function ($user) {
        $user = \App\Models\User::find($user);
        return new \App\Mail\AccountClaimed($user, "The email has been changed");
    });

    Route::get('email-changed', function () {
        return new \App\Mail\EmailChanged();
    });

    Route::get('captain-reminder/{user}', function ($user) {
        $user = \App\Models\User::find($user);
        return new \App\Mail\RemindCaptainOfNewUser($user);
    });

    Route::get('contact-players', function () {
        $subject = "A simple test";
        $body = "The body content\nwith a new line";
        return new \App\Mail\ContactPlayers($subject, $body);
    });

    // try with /mailable/game-reminder/300/240
    Route::get('game-reminder/{date}/{team}', function ($date, $team) {
        $date = \App\Models\Date::find($date);
        $team = \App\Models\Team::find($team);
        return new \App\Mail\PlayDayEmailReminder($date, $team);
    });
});

require __DIR__ . '/auth.php';
