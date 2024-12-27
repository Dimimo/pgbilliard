<?php

namespace App\Livewire\Chat;

use App\Constants;
use App\Events\MessagePosted;
use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
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

    #[On('echo:chat-room,message-posted')]
    public function MessagePosted($room, $message): void
    {
        $this->showNewOrderNotification = true;
        $message = ChatMessage::find($message);
        if ($message->room->id === $room->id) {
            dd($message);
        }
    }

    public function postMessage(): void
    {
        $this->authorize('create', $this->room);
        $validated = $this->validate();
        $data = [
            'message' => $validated['new_chat'],
            'chat_room_id' => $this->room->id,
        ];
        $message = auth()->user()->chatMessages()->create($data);
        $this->chats->add($message);
        if (! $this->room->users->contains(auth()->user())) {
            $this->room
                ->users()
                ->get(['id', 'name'])
                ->push(
                    $message
                    ->user()
                    ->first(['id', 'name'])
                );
        }
        $this->dispatch('userSelected')->to(Invited::class);
        broadcast(new MessagePosted($message));
        $this->reset('new_chat');
    }
}
