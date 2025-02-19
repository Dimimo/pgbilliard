<?php

namespace App\Console;

use App\Jobs\PlayDayReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('day-scores')->dailyAt('12:00');
        $schedule->job(new PlayDayReminder())->dailyAt('12:00');

        if (! str_contains(shell_exec('ps xf'), 'php artisan queue:work --queue=high,default --tries=2')) {
            //https://www.tecmint.com/run-linux-command-process-in-background-detach-process/
            $schedule->command('queue:work --queue=high,default --tries=2')->runInBackground();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
