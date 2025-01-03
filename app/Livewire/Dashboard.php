<?php

namespace App\Livewire;

use App\Models\Chat\ChatRoom;
use App\Models\Forum\Post;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use App\Taps\Cycle;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    public User $user;
    public ?Team $team;
    public ?Player $player = null;
    public Collection $rooms;

    public function mount(): void
    {
        //$this->user = User::find(1);
        $this->team = Team::tap(new Cycle())
            ->has('players', '=', 1, 'and', fn ($q) => $q->where('user_id', $this->user->id))
            ->with('players')
            ->first();
        $this->player = $this->team
            ?->players()
            ->where('user_id', $this->user->id)
            ->first();
        $this->rooms = $this->user->chatRooms()
            ->has('users', '=', 1, 'and', fn ($q) => $q->where('user_id', $this->user->id))
            ->with('users')
            ->get()
            ->merge(
                ChatRoom::where('id', 1)->get()
            )->sortBy('id');
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.dashboard');
    }

    #[Computed]
    public function newPosts(): Collection
    {
        return Post::where('updated_at', '>', session('last_login'))->get();
    }
}