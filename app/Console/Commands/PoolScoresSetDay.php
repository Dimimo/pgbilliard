<?php

namespace App\Console\Commands;

use App\Models\Date;
use Illuminate\Console\Command;

class PoolScoresSetDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pool:day-scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the daily pool scores to zero to activate Live Scores';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $today = \Illuminate\Support\Facades\Date::now()->appTimezone()->format('Y-m-d');
        $dates = Date::query()->where('date', $today)->get();
        foreach ($dates as $date) {
            dispatch(new \App\Jobs\PoolSetDayScores($date));
        }
        $dates->count() ? $count = $dates->count() : $count = 'No';
        $message = "The daily Pool score for $today has been run. $count reset requests has been dispatched.";
        \Illuminate\Support\Facades\Log::info('[PoolScoreSetDay] ' . $message);
        $this->comment($message);
    }
}
