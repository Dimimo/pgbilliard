<?php

namespace App\Livewire;

use App\Models\Admin;

trait WithHasAccess
{
    public bool $hasAccess = false;
    public array $adminIds;

    public function mountWithHasAccess(): void
    {
        if (auth()->check()) {
            $this->adminIds = Admin::all()->pluck('user_id')->toArray();
            if (in_array(auth()->id(), $this->adminIds)) {
                $this->hasAccess = true;
            }
        }
    }
}
