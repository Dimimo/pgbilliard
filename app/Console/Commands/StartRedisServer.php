<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

#[\Illuminate\Console\Attributes\Description('Start the redis server')]
#[\Illuminate\Console\Attributes\Signature('queue:start-redis-server')]
class StartRedisServer extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        shell_exec('redis-server >> /dev/null 2>&1');
        $this->comment('The redis server has started');
    }
}
