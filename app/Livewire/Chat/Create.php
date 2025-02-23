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
        'string',
        'min:2',
        'max:'.Constants::CHATROOM_TITLE,
        'unique:'.ChatRoom::class.',name',
    ], message: [
        'required' => 'A chat room name is required',
        'min' => 'A room name must have a minimum of 2 chars',
        'max' => 'A room name can\'t have more than '.Constants::FORUM_TITLE.' chars',
        'unique' => 'This room name already exists',
    ])]
    public string $name = '';
    #[Validate('boolean')]
    public ?bool $private = false;
    public bool $new = false;

    public function mount(ChatRoom $room): void
    {
        $this->room = $room;
        $this->name = $room->name ?: '';
        $this->private = $room->private;
        $this->new = ! str_contains(URL::current(), 'chat/edit');
    }

    public function render(): View
    {
        return view('livewire.chat.create');
    }

    public function create(): void
    {
        $this->authorize('create', ChatRoom::class);
        $date = array_merge($this->validate(), ['user_id' => Auth::id()]);
        $this->room = ChatRoom::create($date);
        $this->dispatch('room-created');
        auth()->user()->chatRooms()->attach($this->room->id);
        ChatMessage::create([
            'message' => 'Welcome to the "'.$this->room->name.'" chat',
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
