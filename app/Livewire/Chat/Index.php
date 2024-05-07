<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Index extends Component
{
    public ChatRoom $chatRoom;

    public Collection $public_rooms;

    public Collection $private_rooms;

    public function mount(): void
    {
        $this->chatRoom = ChatRoom::with(['messages.user' => fn ($q) => $q->select(['id', 'name'])])->find(1);
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
            ->filter(fn (ChatRoom $room) => $room->users->where('id', Auth::id())->count() === 1);
    }

    public function render(): View
    {
        return view('livewire.chat.index');
    }
}
