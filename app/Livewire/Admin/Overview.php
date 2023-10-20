<?php

namespace App\Livewire\Admin;

use App\Livewire\WithUsersSelect;
use App\Models\Admin;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Overview extends Component
{
    use WithUsersSelect;

    public Collection $admins;

    public array $ids;

    public ?int $user_id = null;

    public function mount()
    {
        $this->loadVars();
    }

    public function render(): View
    {
        return view('livewire.admin.overview');
    }

    private function loadVars()
    {
        $this->admins = Admin::all();
        $this->ids = $this->admins->pluck('user_id')->toArray();
        $this->user_id = null;
    }

    public function updatedUserId($admin_user_id)
    {
        Admin::create(['user_id' => $admin_user_id, 'assigned_by' => Auth::id()]);
        $this->dispatch('admin-added');
        $this->loadVars();
    }

    public function removeAdmin($remove_id)
    {
        Admin::whereUserId($remove_id)->first()->delete();
        $this->dispatch('admin-removed');
        $this->loadVars();
    }
}
