<?php

namespace App\Livewire;

trait WithUsersSelect
{
    use WithLoadUsersList;

    public function MountWithUsersSelect(): void
    {
        $this->loadUsersList();
    }
}
