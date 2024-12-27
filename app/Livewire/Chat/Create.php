<?php

namespace App\Livewire\Chat;

use App\Constants;
use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    private ChatRoom $room;

    #[Validate([
        'required',
        'alpha_num',
        'min:2',
        'max:'.Constants::CHATROOM_TITLE,
        'unique:'.ChatRoom::class.',name',
    ], message: [
        'required' => 'A chat room name is required',
        'min' => 'A room name must have a minimum of 2 chars',
        'max' => 'A room name can\'t have more than '.Constants::FORUM_TITLE.' chars',
        'unique' => 'This room name already exists',
    ])]
    public string $name;

    #[Validate('nullable|boolean')]
    public bool $private;

    public bool $new;

    public function mount(ChatRoom $room): void
    {
        $this->room = $room;
        $this->name = $room->name ?: '';
        $this->private = $room->private;
        str_contains(URL::current(), 'chat/edit') ? $this->new = false : $this->new = true;
    }

    public function render(): View
    {
        return view('livewire.chat.create');
    }

    public function create(): void
    {
        $this->authorize(ChatRoom::class);
        $date = array_merge($this->validate(), ['user_id' => Auth::id()]);
        $this->room = ChatRoom::create($date);
        $this->dispatch('room-created');
        ChatMessage::create([
            'message' => 'Welcome to my '.$this->room->name.' chat room',
            'user_id' => $this->room->user_id,
            'chat_room_id' => $this->room->id,
        ]);
        $this->redirect(route('chat.room', ['chatRoom' => $this->room]), navigate: true);
    }

    public function update(): void
    {
        $this->authorize('edit', $this->room);
        $this->room->update($this->validate());
        $this->dispatch('room-updated');
        $this->redirect(route('chat.room', ['chatRoom' => $this->room]), navigate: true);
    }
}
