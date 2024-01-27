<?php

namespace App\Livewire;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Collection;

trait WithAdmins
{
    public Collection $admins;

    public array $adminIds;

    public function mountWithAdmins(): void
    {
        $this->loadAdmins();
    }

    private function loadAdmins(): void
    {
        $this->admins = Admin::all();
        $this->adminIds = $this->admins->pluck('user_id')->toArray();
    }
}
