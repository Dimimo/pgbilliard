<?php

namespace App\Services;

use App\Models\Event;

class LiveScoreUpdater
{
    public function __construct(public Event $event)
    {
    }

    public function getEventScores(): Event
    {
        foreach (['home' => 'score1', 'visit' => 'score2'] as $place => $score) {
            $$score = $this->event->games()
                ->select('position')
                ->whereHome($place === 'home')
                ->whereWin(true)
                ->groupBy(['position'])
                ->get()->count();
        }

        $this->event->update(['score1' => $score1, 'score2' => $score2]);

        return $this->event;
    }
}
