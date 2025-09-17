<?php

namespace App\Livewire\Admin;

use App\Livewire\WithAdmins;
use App\Livewire\WithUsersSelect;
use App\Models\Admin;
use Auth;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Overview extends Component
{
    use WithAdmins;
    use WithUsersSelect;

    #[Validate(['required', 'exists:users,id'])]
    public ?int $user_id = null;

    public function mount(): void
    {
        $this->user_id = null;
    }

    public function render(): View
    {
        return view('livewire.admin.overview');
    }

    private function loadVars(): void
    {
        $this->loadAdmins();
        $this->user_id = null;
    }

    public function updatedUserId($admin_user_id): void
    {
        Admin::query()->create(['user_id' => $admin_user_id, 'assigned_by' => Auth::id()]);
        $this->dispatch('admin-added');
        $this->loadVars();
    }

    public function removeAdmin($remove_id): void
    {
        Admin::query()->whereUserId($remove_id)->first()->delete();
        $this->dispatch('admin-removed');
        $this->loadVars();
    }
}
