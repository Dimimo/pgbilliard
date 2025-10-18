<?php

namespace App\Livewire\Date;

use App\Events\ScoreEvent;
use App\Services\Consolidator;

trait ConsolidateTrait
{
    /**
     * consolidate the score, when the game is over the final score is admitted, setting the confirmed switch to true
     * broadcast the event and if all games are finished for the day, send out the emails with the final scores
     */
    public function consolidate(): void
    {
        $finishGame = new Consolidator($this->event);
        $sendEmails = $finishGame->consolidate();
        $this->dispatch('update-settings', specific: 'confirmed')->to(Schedule::class);
        $this->dispatch('score-confirmed-' . $this->event->id);
        broadcast(new ScoreEvent($this->season->id, $this->event->id))->toOthers();
        if ($sendEmails) {
            $finishGame->sendEmails();
        }
    }
}
