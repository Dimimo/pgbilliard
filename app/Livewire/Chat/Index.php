<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    public ChatRoom $room;
    public Collection $public_rooms;
    public Collection $private_rooms;

    public function mount(): void
    {
        $this->room = ChatRoom::with(['messages.user' => fn ($q) => $q->select(['id', 'name'])])->find(1);
    }

    public function render(): View
    {
        return view('livewire.chat.index');
    }
}
