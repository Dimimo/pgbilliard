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
        // $schedule->command('queue:work --tries=2 --max-time=900 --queue=high,default')->runInBackground();
        $schedule->command('day-scores')->dailyAt('12:00');
        // $schedule->command('queue:start-redis-server')->everyFiveMinutes()->runInBackground();
        $schedule->job(new PlayDayReminder())->dailyAt('12:00');
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('01:15');

        /*if (str_contains(shell_exec('ps xa'), 'tries=2') === false) {
            //https://www.tecmint.com/run-linux-command-process-in-background-detach-process/
            $schedule->command('queue:work --tries=2 --max-time=930 --queue=high,default')->runInBackground();
        }*/
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
