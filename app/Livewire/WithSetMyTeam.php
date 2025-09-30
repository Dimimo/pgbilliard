<?php

namespace App\Livewire;

trait WithSetMyTeam
{
    public ?int $my_team = null;

    public function mountWithSetMyTeam(): void
    {
        $this->my_team = session('my_team');
    }

    public function setMyTeam(int $id): void
    {
        session('my_team') === $id
            ? session()->put('my_team', $this->my_team = $this->setMyTeamBasedOnUser())
            : session()->put('my_team', $this->my_team = $id);
    }

    private function setMyTeamBasedOnUser(): ?int
    {
        if (!auth()->check()) {
            return null;
        }
        // @phpstan-ignore-next-line
        $date = $this->date ?? $this->dates->first();
        return $date->getTeam(auth()->user())?->id;
    }
}
