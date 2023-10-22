<?php

namespace App\Livewire;

use App\Models\Admin;
use Auth;

trait WithHasAccess
{
    public bool $hasAccess = false;

    private array $userIds = [1, 9, 1053];

    public function mountWithHasAccess(): void
    {
        $this->hasAccess = Admin::whereId(Auth::id())->exists();
    }
}
