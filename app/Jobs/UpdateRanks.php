<?php

namespace App\Jobs;

use App\Livewire\UpdateRanksTrait;
use App\Models\Season;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateRanks implements ShouldQueue
{
    use Queueable;
    use UpdateRanksTrait;

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
        $this->updateRanks();
    }
}
