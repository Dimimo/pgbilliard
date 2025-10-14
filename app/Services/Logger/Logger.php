<?php

namespace App\Services\Logger;

abstract class Logger
{
    public function buildLogChannel(): \Psr\Log\LoggerInterface
    {
        date_default_timezone_set(config('app.app_timezone'));

        return \Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/scores.log'),
        ]);
    }

    public function resetTimeZone(): void
    {
        date_default_timezone_set(config('app.timezone'));
    }
}
