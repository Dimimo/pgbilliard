<?php

namespace App\Services\Logger;

use App\Models\Event;
use App\Models\Game;

class LogGames extends Logger
{
    public function __construct()
    {
    }

    public function logGameChanges(Game $game): void
    {
        $this->logEventChanges($game->event, $game->home ? 'score1' : 'score2');
        // look for the reverse, the db value is changed after getting the game record
        $status = ! $game->win ? "won game" : "lost game";
        $message = "[Day Schedule] "
            . auth()->user()->name
            . " set the score of "
            . $game->player->name
            . " ("
            . $game->team->name
            . ") to a $status";
        $this->buildLogChannel()->info($message);
        $this->resetTimeZone();
    }

    public function logEventChanges(Event $event, string $field): void
    {
        $message = "["
            . $event->date->date->appTimezone()->format("d/m/Y")
            . " {$event->team_1->name} - {$event->team_2->name}  ($event->score1 - $event->score2)] "
            . auth()->user()->name
            . " changed $field to "
            . $event->$field;

        $this->buildLogChannel()->info($message);
        $this->resetTimeZone();
    }
}
