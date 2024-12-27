<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class UserSelect extends Component
{
    use WithChatUsers;

    public ChatRoom $room;

    public function mount(ChatRoom $room): void
    {
        $this->room = $room;
        $this->search = '';
        $this->getListUsers();
    }

    public function render(): View
    {
        return view('livewire.chat.user-select');
    }

    public function updatedSearch($search, $v): void
    {
        $this->search = $search;
        $this->getListUsers();
    }

    #[On('userSelected')]
    public function userSelected(): void
    {
        $this->getListUsers();
    }
}
