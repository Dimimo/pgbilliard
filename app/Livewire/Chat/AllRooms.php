<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class AllRooms extends Component
{
    public Collection $public_rooms;
    public Collection $private_rooms;

    #[On('userSelected')]
    public function mount(): void
    {
        $this->public_rooms = ChatRoom::query()->wherePrivate(false)
            //->whereKeyNot(1)
            ->with(['users' => fn ($q) => $q->select(['id', 'name'])])
            ->orderBy('name')
            ->get();

        $this->private_rooms = ChatRoom::query()->wherePrivate(true)
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

    public function deleteRoom(int $room_id): void
    {
        if ($room_id === 1) {
            return;
        }
        $room = ChatRoom::query()->find($room_id);
        $this->authorize('delete', $room);
        $room->messages()->delete();
        $room->users()->detach();
        $room->delete();
        $this->redirect(route('chat.index'), navigate: true);
    }
}
