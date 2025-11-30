<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Carbon;

trait WithLoadUsersList
{
    public array $users = [];
    public string $carbon_sub = '20 years';

    private function loadUsersList(): void
    {
        $this->users = $this->queryUsers()
            ->pluck('name', 'id')
            ->toArray();
    }

    private function loadUsersCollection(array $whereNotIn = []): \Illuminate\Database\Eloquent\Collection
    {
        return $this->queryUsers()->whereNotIn('id', $whereNotIn)->get();
    }

    protected function queryUsers(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query()
            ->where('last_game', '>', \Illuminate\Support\Facades\Date::now()->sub($this->carbon_sub))
            ->orderBy('name')
            ->whereNotIn('id', [1]); //get rid of the administrator
    }

    public function updatedWithLoadUsersList($model, $value): void
    {
        $this->validateOnly('user_id');
        if ($model === 'carbon_sub') {
            $this->carbon_sub = $value;
            $this->loadUsersList();
            $this->dispatch('users-list-updated');
        }
    }
}
