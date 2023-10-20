<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScoreEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Event $score;

    /**
     * Create the event listener.
     */
    public function __construct(Event $score)
    {
        $this->score = $score;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return ['pool-score'];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'score-event';
    }
}
