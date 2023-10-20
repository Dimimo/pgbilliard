<?php

namespace App\Livewire;

trait WithSetMyTeam
{
    public int $my_team = 0;

    public function mountWithSetMyTeam(): void
    {
        $this->my_team = session('my_team', 0);
    }

    public function setMyTeam(int $id): void
    {
        session('my_team') === $id
            ? session()->put('my_team', $this->my_team = 0)
            : session()->put('my_team', $this->my_team = $id);
    }
}
