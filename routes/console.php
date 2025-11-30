<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function (): void {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::dailyAt('12:00')
    ->group(function (): void {
        Schedule::command('pool:day-scores');
        Schedule::command('pool:day-reminder');
    });

Schedule::dailyAt('01:00')
    ->command('backup:run')
    ->after(function (): void {
        Schedule::command('backup:clean');
    });
