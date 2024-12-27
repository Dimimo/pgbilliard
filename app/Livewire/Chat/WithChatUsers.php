<?php

namespace App\Livewire\Chat;

use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;

trait WithChatUsers
{
    #[Validate(['nullable', 'string'])]
    public ?string $search;
    private array $ids;
    public Collection $list_users;

    public function mountWithChatUsers(): void
    {
        $this->search = '';
        $this->getListUsers();
    }

    public function toggleUser(int $user_id): void
    {
        $this->room->users()->toggle($user_id);
        $this->room->refresh()->loadMissing([
            'users' => fn ($q) => $q->select(['id', 'name']),
            'owner',
            'messages.user' => fn ($q) => $q->select(['id', 'name']),

        ]);
        $this->getListUsers();
        $this->dispatch('userSelected');
    }

    private function getListUsers(): void
    {
        $this->getIds();
        if ($this->search) {
            $this->list_users = User::whereNotIn('id', $this->ids)
                ->where('name', 'LIKE', "%$this->search%")
                ->orderBy('name')
                ->get(['id', 'name']);
        } else {
            $this->list_users = User::whereNotIn('id', $this->ids)
                ->orderBy('name')
                ->get(['id', 'name']);
        }
    }

    private function getIds(): void
    {
        $this->ids = array_merge($this->room->users->pluck('id')->toArray(), [1]);
    }
}
