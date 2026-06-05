<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

#[
    \Illuminate\Console\Attributes\Description(
        'Send the play day reminder the day before the next event',
    ),
]
#[\Illuminate\Console\Attributes\Signature('pool:day-reminder')]
class DayReminder extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch_sync(new \App\Jobs\PlayDayReminder());
    }
}
