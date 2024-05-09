<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Room extends Component
{
    public ChatRoom $room;

    public Collection $list_users;

    #[Validate(['nullable', 'string'])]
    public ?string $search;

    private array $ids;

    public function mount(ChatRoom $chatRoom): void
    {
        $this->room = $chatRoom->loadMissing([
            'users' => fn ($q) => $q->select(['id', 'name']),
            'owner',
            'messages.user' => fn ($q) => $q->select(['id', 'name']),
        ]);
        $this->search = '';
        $this->getListUsers();
    }

    public function render(): View
    {
        return view('livewire.chat.room');
    }

    public function updatedSearch(string $search): void
    {
        $this->search = $search;
        $this->getListUsers();
        $this->search = '';
    }

    public function toggleUser(int $user_id): void
    {
        $this->room->users()->toggle($user_id);
        $this->room->refresh()->loadMissing([
            'users' => fn ($q) => $q->select(['id', 'name']),
            'owner',
            'messages.user' => fn ($q) => $q->select(['id', 'name']),

        ]);
        $this->getListUsers();
    }

    public function deleteUser(int $user_id): void
    {
        //
    }

    private function getListUsers(): void
    {
        $this->getIds();
        if ($this->search) {
            $this->list_users = User::whereNotIn('id', $this->ids)
                ->where('name', 'LIKE', "%$this->search%")
                ->orderBy('name')
                ->get(['id', 'name']);
        } else {
            $this->list_users = User::whereNotIn('id', $this->ids)
                ->orderBy('name')
                ->get(['id', 'name']);
        }
    }

    private function getIds(): void
    {
        $this->ids = array_merge($this->room->users->pluck('id')->toArray(), [1]);
    }
}
