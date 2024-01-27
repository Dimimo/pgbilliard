<?php

namespace App\Livewire;

trait WithHasAccess
{
    use WithAdmins;

    public bool $hasAccess = false;

    public function mountWithHasAccess(): void
    {
        if (auth()->check()) {
            if (in_array(auth()->id(), $this->adminIds)) {
                $this->hasAccess = true;
            }
        }
    }
}
