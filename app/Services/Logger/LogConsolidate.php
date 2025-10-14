<?php

namespace App\Services\Logger;

use App\Models\Event;

class LogConsolidate extends Logger
{
    public function __construct(public Event $event)
    {
    }

    public function message(): void
    {
        $message = "["
            . $this->event->date->date->appTimezone()->format("d/m/Y")
            . " {$this->event->team_1->name} - {$this->event->team_2->name}] "
            . auth()->user()->name
            . " confirmed the game, end score is {$this->event->score1} - {$this->event->score2}";

        $this->buildLogChannel()->info($message);
        $this->resetTimeZone();
    }
}
