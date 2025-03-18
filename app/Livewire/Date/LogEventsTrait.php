<?php

namespace App\Livewire\Date;

use App\Models\Game;

trait LogEventsTrait
{
    private function logScheduleChanges(Game $game): void
    {
        $this->logChanges($game->home ? 'score1' : 'score2');
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
        date_default_timezone_set(config('app.timezone'));
    }

    private function logChanges(string $field): void
    {
        $message = "["
            . $this->event->date->date->appTimezone()->format("d/m/Y")
            . " {$this->event->team_1->name} - {$this->event->team_2->name}  ({$this->event->score1} - {$this->event->score2})] "
            . auth()->user()->name
            . " changed $field to "
            . $this->event->$field;

        $this->buildLogChannel()->info($message);
        date_default_timezone_set(config('app.timezone'));
    }

    private function logConsolidate(): void
    {
        $message = "["
            . $this->event->date->date->appTimezone()->format("d/m/Y")
            . " {$this->event->team_1->name} - {$this->event->team_2->name}] "
            . auth()->user()->name
            . " confirmed the game, end score is {$this->event->score1} - {$this->event->score2}";

        $this->buildLogChannel()->info($message);
        date_default_timezone_set(config('app.timezone'));
    }

    private function buildLogChannel(): \Psr\Log\LoggerInterface
    {
        date_default_timezone_set(config('app.app_timezone'));

        return \Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/scores.log'),
        ]);
    }
}
