<?php

namespace App\Livewire\Chat;

use App\Models\Chat\ChatRoom;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Invited extends Component
{
    use WithChatUsers;

    public ChatRoom $room;

    public function mount(ChatRoom $room): void
    {
        $this->room = $room;
    }

    public function render(): View
    {
        return view('livewire.chat.invited');
    }

    #[On('userSelected')]
    public function userSelected(): void
    {
        $this->getListUsers();
    }
}
