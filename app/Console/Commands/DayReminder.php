<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DayReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:day-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the play day reminder the day before the next event';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch(new \App\Jobs\PlayDayReminder());
    }
}
