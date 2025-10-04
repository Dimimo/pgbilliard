<?php

namespace App\Livewire\Admin\Players;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class Overview extends Component
{
    public Collection $users;
    public string $carbon_sub = 'now';
    public string $orderBy = 'name';
    public bool $asc = true;

    public function mount(): void
    {
        $this->loadUsersList();
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.admin.players.overview')->with([
            'users' => $this->users,
        ]);
    }

    private function loadUsersList(): void
    {
        $date_filter = Carbon::now()->sub($this->carbon_sub);
        $admin_ids = Admin::all()->pluck('id')->toArray();
        $this->users = User::query()
            ->select(['id', 'name', 'email', 'contact_nr', 'last_game'])
            ->whereNotIn('id', $admin_ids)
            ->where('last_game', '<', $date_filter)
            ->withCount(['games', 'players'])
            ->with([
                'players' => fn (HasMany $q) => $q->orderByDesc('team_id')
                    ->with(['team' => fn ($t) => $t->select(['id', 'name'])])
                    ->take(1)
            ])
            ->orderBy($this->orderBy, $this->asc ? 'asc' : 'desc')
            ->get();
    }

    public function updatedCarbonSub($value): void
    {
        $this->carbon_sub = $value;
        $this->loadUsersList();
    }

    public function sortColumn(string $orderBy): void
    {
        if (Str::contains('last_game|games_count|players_count', $orderBy)) {
            $this->orderBy === $orderBy ? $this->asc = !$this->asc : $this->asc = false;
        } else {
            $this->orderBy === $orderBy ? $this->asc = !$this->asc : $this->asc = true;
        }
        $this->orderBy = $orderBy;
        $this->loadUsersList();
    }

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        if ($user->has('games')) {

        }
    }
}
