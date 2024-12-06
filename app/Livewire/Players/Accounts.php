<?php

namespace App\Livewire\Players;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Accounts extends Component
{
    public Collection $users;

    public function mount(): void
    {
        $this->users = $this->getUsers();
    }

    public function render(): View
    {
        return view('livewire.players.accounts');
    }

    private function getUsers(): Collection
    {
        return User::where('email', 'like', "%\@pgbilliard\.com")
            ->whereNotIn('id', [1]) //get rid of the administrator
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'last_game']);
    }
}
