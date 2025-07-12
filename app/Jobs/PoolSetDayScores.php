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
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
     * If the same team plays itself, it means the final, no changes
     * If team 2 is a BYE, no scores given but set to confirmed
     */
    public function handle(): void
    {
        date_default_timezone_set(config('app.app_timezone'));

        if ($this->date->events()->count() > 0) {
            foreach ($this->date->events as $event) {
                if (! $event->score1 && ! $event->score2) {
                    if ($event->team_1->id !== $event->team_2->id || $event->team_2->name !== 'BYE') {
                        $event->update(['score1' => 0, 'score2' => 0]);
                    } elseif ($event->team_2->name === 'BYE') {
                        $event->update(['score1' => null, 'score2' => null, 'confirmed' => true]);
                    }
                }
            }
        }
        $this->buildLogChannel()->info("The day scores has been set to 0-0");

        date_default_timezone_set(config('app.timezone'));
    }

    private function buildLogChannel(): \Psr\Log\LoggerInterface
    {
        return \Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/scores.log'),
        ]);
    }
}
