<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Room extends Component
{
    use WithChatUsers;

    public ChatRoom $room;

    public function mount(ChatRoom $chatRoom): void
    {
        $this->room = $chatRoom->loadMissing([
            'users' => fn ($q) => $q->select(['id', 'name']),
            'owner',
            'messages.user' => fn ($q) => $q->select(['id', 'name']),
        ]);
    }

    public function render(): View
    {
        return view('livewire.chat.room');
    }
}
