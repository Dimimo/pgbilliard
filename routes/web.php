<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('schedule/new', function () {
    return response()->download(public_path('day-schedule.pdf'));
})->name('schedule.new');

Route::get('mailable/date/{date}', function ($date) {
    $date = \App\Models\Date::find($date);
    return new \App\Mail\DayScoresConfirmed($date);
});

Route::get('mailable/date/{date}/admin', function ($date) {
    $date = \App\Models\Date::find($date);
    $send_to = ['Joe Doe', 'Jane Doe'];
    return new \App\Mail\DayScoresToAdmin($date, \Arr::sort($send_to));
});

Route::get('mailable/account-claimed/{user}', function ($user) {
    $user = \App\Models\User::find($user);
    return new \App\Mail\AccountClaimed($user, "The email has been changed");
});

Route::get('mailable/email-changed', function () {
    return new \App\Mail\EmailChanged();
});

Route::get('mailable/captain-reminder/{user}', function ($user) {
    $user = \App\Models\User::find($user);
    return new \App\Mail\RemindCaptainOfNewUser($user);
});

Route::get('mailable/contact-players', function () {
    $subject = "A simple test";
    $body = "The body content\nwith a new line";
    return new \App\Mail\ContactPlayers($subject, $body);
});

// try with /mailable/game-reminder/300/240
Route::get('mailable/game-reminder/{date}/{team}', function ($date, $team) {
    $date = \App\Models\Date::find($date);
    $team = \App\Models\Team::find($team);
    return new \App\Mail\PlayDayEmailReminder($date, $team);
});

require __DIR__.'/auth.php';
