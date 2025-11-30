<?php

namespace App\Livewire\Chat;

use App\Constants;
// use App\Events\MessagePosted;
use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Messages extends Component
{
    public bool $showNewOrderNotification = false;
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
    public string $new_chat = '';
    public int $max_chars = Constants::CHATROOM_MESSAGE;

    public function mount(ChatRoom $room): void
    {
        $this->room = $room;
        $this->chatMessages();
    }

    public function render(): View
    {
        return view('livewire.chat.messages');
    }

    #[On('refresh-messages')]
    public function chatMessages(): void
    {
        $this->chats = $this->room
            ->messages()->oldest()
            ->with(['user' => fn ($q) => $q->select(['id', 'name'])])
            ->get();
    }

    public function updatedNewChat(): void
    {
        $this->validateOnly('new_chat');
    }

    /*#[On('echo:chat-room,message-posted')]
    public function MessagePosted($room, $message): void
    {
        $this->showNewOrderNotification = true;
        $message = ChatMessage::find($message);
        if ($message->room->id === $room->id) {
            dd($message);
        }
    }*/

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
        // broadcast(new MessagePosted($message));
        $this->reset('new_chat');
    }

    public function deleteMessage($message): void
    {
        $message = ChatMessage::query()->find($message);
        $this->authorize('delete', $message);
        $message->delete();
        $this->chatMessages();
        $this->dispatch('message-deleted');
    }
}
