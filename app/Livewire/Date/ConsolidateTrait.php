<?php

namespace App\Livewire\Date;

use App\Events\ScoreEvent;
use App\Mail\DayScoresConfirmed;
use App\Mail\DayScoresToAdmin;
use Illuminate\Support\Str;

trait ConsolidateTrait
{
    use LogEventsTrait;

    public function consolidate(): void
    {
        $this->event->update(['confirmed' => true]);
        $this->confirmed = true;
        $this->dispatch('score-confirmed-'.$this->event->id);
        $this->logConsolidate();
        broadcast(new ScoreEvent($this->season->id, $this->event->id))->toOthers();

        // here we check if all events are confirmed, if so, email all participating players, only in production!
        if ($this->event->date->events->every(fn ($value) => $value->confirmed === true)) {
            if (app()->environment() === 'production') {
                $send_to = [];
                $players = $this->event->date->players();

                foreach ($players as $user) {
                    // avoid players that haven't been claimed yet
                    if (!Str::contains($user->email, '@pgbilliard.com')) {
                        \Mail::to($user)->queue(new DayScoresConfirmed($this->event->date));
                        $send_to = \Arr::add($send_to, $user->id, $user->name);
                    }
                }

                \Mail::send(new DayScoresToAdmin($this->event->date, \Arr::sort($send_to)));

                $message = "["
                    . $this->event->date->date->appTimezone()->format("d/m/Y")
                    ."] All day scores confirmed, "
                    . count($send_to)
                    . " emails have been sent";
                $this->buildLogChannel()->info($message);

                date_default_timezone_set(config('app.timezone'));
            }
        }
    }
}
