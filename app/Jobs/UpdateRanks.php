<?php

namespace App\Jobs;

use App\Services\RankUpdater;
use App\Models\Season;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateRanks implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Season $season)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Illuminate\Support\Facades\Log::info("Starting rank update for season {$this->season->id}");
        $rankUpdater = new RankUpdater($this->season->id);
        $rankUpdater->update();
        \Illuminate\Support\Facades\Log::info("Completed rank update for season {$this->season->id}");
    }
}
