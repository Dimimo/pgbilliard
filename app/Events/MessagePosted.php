<?php

namespace App\Events;

use App\Models\Chat\ChatMessage;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessagePosted implements ShouldBroadcastNow, ShouldDispatchAfterCommit
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public ChatMessage $message,
    ) {
        $this->user = $this->message->user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PresenceChannel
     */
    public function broadcastOn(): PresenceChannel
    {
        \Log::info('from the event');
        \Log::info($this->message->toJson());
        return new PresenceChannel('chat.'.$this->message->room->id);
    }

    /*public function broadcastAs(): string
    {
        return 'message.posted';
    }*/

    public function broadcastWith(): array
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'data' => $this->message->message,
            'created_id' => $this->message->created_at
        ];
    }
}
