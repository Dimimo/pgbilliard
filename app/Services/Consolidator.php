<?php

namespace App\Services;

use App\Events\ScoreEvent;
use App\Livewire\Date\LogEventsTrait;
use App\Mail\DayScoresConfirmed;
use App\Mail\DayScoresToAdmin;
use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Consolidator
{
    use LogEventsTrait;

    public Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function consolidate(): bool
    {
        $this->event->update(['confirmed' => true]);
        $this->logConsolidate();
        // let the others know the game is finished with a final score
        broadcast(new ScoreEvent($this->event->date->season_id, $this->event->id))->toOthers();

        return app()->environment() === 'production' && $this->event->date->events->every(fn ($value) => $value->confirmed === true);
    }

    /**
     *here we check if all events are confirmed, if so, email all participating players, only in production!
     * */
    public function sendEmails(): void
    {
        $send_to = [];
        $players = $this->event->date->players();

        foreach ($players as $user) {
            // avoid players that haven't been claimed yet
            if (!Str::contains($user->email, '@pgbilliard.com')) {
                Mail::to($user)->queue(new DayScoresConfirmed($this->event->date));
                $send_to = Arr::add($send_to, $user->id, $user->name);
            }
        }

        Mail::send(new DayScoresToAdmin($this->event->date, Arr::sort($send_to)));

        $message = "["
            . $this->event->date->date->appTimezone()->format("d/m/Y")
            . "] All day scores confirmed, "
            . count($send_to)
            . " emails have been sent";
        $this->buildLogChannel()->info($message);

        date_default_timezone_set(config('app.timezone'));
    }
}
