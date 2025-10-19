<?php

namespace App\Services;

use App\Models\Event;
use App\Models\Format;
use App\Models\Game;
use App\Models\Position;

class ScheduleManager
{
    public function __construct(public Event $event)
    {
    }

    // returns the chosen format based on the games schedule
    public function setFormat(): ?Format
    {
        return $this->event
            ->games()
            ->first()
            ?->schedule
            ->format;
    }

    public function recreateMatrix(): array
    {
        $home_matrix = Position::with('player.user')
            ->where([['event_id', $this->event->id], ['home', true]])
            ->orderBy('rank')
            ->get();

        $visit_matrix = Position::with('player.user')
            ->where([['event_id', $this->event->id], ['home', false]])
            ->orderBy('rank')
            ->get();

        return [$home_matrix, $visit_matrix];
    }

    public function checkThirdGame(Format $format): Event
    {//dd($this->event->games()->where('position', 15)->count());
        if ($this->event->games()->where('position', 15)->count() === 0) {
            $schedules = $format->schedules()->wherePosition(15)->get();
            foreach ($schedules as $schedule) {
                $values = [
                    'schedule_id' => $schedule->id,
                    'event_id' => $this->event->id,
                    'team_id' => $schedule->home ? $this->event->team_1->id : $this->event->team_2->id,
                    'player_id' => null,
                    'user_id' => null,
                    'position' => 15,
                    'home' => $schedule->home,
                ];
                (new Game())->create($values);
            }
            return $this->event->refresh();
        }
        return $this->event;
    }
}
