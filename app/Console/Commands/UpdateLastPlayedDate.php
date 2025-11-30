<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateLastPlayedDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:last-played';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the user\'s last played date if applicable';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        dispatch_sync(new \App\Jobs\UpdateUsersLastPlayedDate());
    }
}
