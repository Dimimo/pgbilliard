<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartRedisServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:start-redis-server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the redis server';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        shell_exec('redis-server >> /dev/null 2>&1');
        $this->comment('The redis server has started');
    }
}
