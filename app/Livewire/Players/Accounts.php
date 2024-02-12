<?php

namespace App\Livewire\Players;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Accounts extends Component
{
    public Collection $users;

    public function mount()
    {
        $this->users = $this->getUsers();
    }

    public function render(): View
    {
        return view('livewire.players.accounts');
    }

    private function getUsers(): Collection
    {
        return User::where('email', 'like', "%\@puertopool\.com")
            ->whereNotIn('id', [1]) //get rid of the administrator
//                ->with(['players'])
            /*->with([
                       'players' => function (HasMany $q)
                       {
                           return $q->orderByDesc('id')->get();
                       },
                   ])*/
            ->orderBy('name')->get(['id', 'name', 'email', 'last_game']);
    }
}
