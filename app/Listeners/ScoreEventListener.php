<?php

namespace App\Listeners;

use App\Events\ScoreEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScoreEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(ScoreEvent $event): ScoreEvent
    {
        return $event;
    }
}
