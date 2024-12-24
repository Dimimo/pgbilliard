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

require __DIR__.'/auth.php';
