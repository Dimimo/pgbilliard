<?php

namespace App\Jobs;

use App\Models\Date;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PoolSetDayScores implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Date $date;

    /**
     * Create a new job instance.
     */
    public function __construct(Date $date)
    {
        $this->date = $date;
    }

    /**
     * Check for events today, if they exist, set the scores to 0-0
     */
    public function handle(): void
    {
        if ($this->date->events()->count() > 0) {
            foreach ($this->date->events as $event) {
                if (! $event->score1 && ! $event->score2) {
                    if ($event->team_1->id !== $event->team_2->id || $event->team_2->name !== 'BYE') {
                        $event->update(['score1' => 0, 'score2' => 0]);
                    }
                }
            }
        }
    }
}
