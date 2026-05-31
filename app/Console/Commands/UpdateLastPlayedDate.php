<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

#[\Illuminate\Console\Attributes\Description('Update the user\'s last played date if applicable')]
#[\Illuminate\Console\Attributes\Signature('pool:last-played')]
class UpdateLastPlayedDate extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch_sync(new \App\Jobs\UpdateUsersLastPlayedDate());
    }
}
