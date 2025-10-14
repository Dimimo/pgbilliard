<?php

namespace App\Jobs;

use App\Services\RankUpdater;
use App\Models\Season;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateRanks implements ShouldQueue
{
    use Queueable;

    public Season $season;

    /**
     * Create a new job instance.
     */
    public function __construct(Season $season)
    {
        $this->season = $season;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $rankUpdater = new RankUpdater($this->season->id);
        $rankUpdater->update();
    }
}
