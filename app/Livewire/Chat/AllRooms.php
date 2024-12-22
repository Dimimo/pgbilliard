<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use Illuminate\Support\Collection;
use Livewire\Component;

class AllRooms extends Component
{
    public Collection $public_rooms;
    public Collection $private_rooms;

    public function mount(): void
    {
        $this->public_rooms = ChatRoom::wherePrivate(false)
            ->whereKeyNot(1)
            ->with(['users' => fn ($q) => $q->select(['id', 'name'])])
            ->orderBy('name')
            ->get();

        $this->private_rooms = ChatRoom::wherePrivate(true)
            ->with(['users' => fn ($q) => $q->select(['id', 'name'])])
            ->withCount('users')
            ->orderBy('name')
            ->get()
            ->filter(fn (ChatRoom $room) => $room->users->where('id', auth()->id())->count() === 1);
    }
    public function render(): \Illuminate\View\View
    {
        return view('livewire.chat.all-rooms');
    }
}
