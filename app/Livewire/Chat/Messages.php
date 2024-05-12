<?php

namespace App\Livewire\Chat;

use App\Constants;
use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Messages extends Component
{
    public $showNewOrderNotification = false;

    public ChatRoom $room;

    public Collection $chats;

    #[Validate([
        'required',
        'min:1',
        'max:'.Constants::CHATROOM_MESSAGE,
    ], message: [
        'required' => 'A chat message can not be empty',
        'max' => 'Shorten your message to '.Constants::CHATROOM_MESSAGE.' characters',
    ])]
    public ?string $new_chat = null;

    public function mount(ChatRoom $room): void
    {
        $this->room = $room;
        $this->chats = $this->room->messages->loadMissing(['user' => fn ($q) => $q->select(['id', 'name'])]);
    }

    public function render(): View
    {
        return view('livewire.chat.messages');
    }

    #[On('echo:public-room,MessagePosted')]
    public function newMessage($event): void
    {
        dd($event);
        $this->showNewOrderNotification = true;
        $message = ChatMessage::find($event->message->id);
    }

    public function postMessage(): void
    {
        $this->authorize('create', ChatRoom::class);
        $this->validate();
        $data = [
            'message' => $this->new_chat,
            'user_id' => Auth::id(),
            'chat_room_id' => $this->room->id,
        ];
        $message = ChatMessage::create($data);
        $this->chats->add($message);
        if (! $this->room->users->contains(Auth::user())) {
            $this->room->users()->attach($message->user_id);
        }
        $this->dispatch('userSelected')->to(Invited::class);
        $this->dispatch('new-message');
        $this->new_chat = null;
    }
}
