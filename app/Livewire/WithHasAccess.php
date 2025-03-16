<?php

namespace App\Livewire;

trait WithHasAccess
{
    public bool $hasAccess = false;

    public function mountWithHasAccess(): void
    {
        $this->hasAccess = session('is_admin', false);
    }
}
