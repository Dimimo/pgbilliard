<?php

namespace App\Livewire;

trait WithSetMyTeam
{
    public ?int $my_team = null;

    public function mountWithSetMyTeam(): void
    {
        $this->my_team = session('my_team');
        if (!$this->my_team && auth()->check()) {
            $this->my_team = $this->setMyTeamBasedOnUser();
        }
    }

    public function setMyTeam(int $id): void
    {
        session('my_team') === $id
            ? session()->put('my_team', $this->my_team = 0)
            : session()->put('my_team', $this->my_team = $id);
    }

    private function setMyTeamBasedOnUser()
    {
        $date = $this->date ?? $this->dates->first();
        return $date->events
            ->map(
                fn ($event) => $event
                    ->team_1
                    ->players
                    ->filter(fn ($player) => $player->user_id == auth()->id())
            )
            ->merge(
                $date->events->map(
                    fn ($event) => $event
                        ->team_2
                        ->players
                        ->filter(fn ($player) => $player->user_id == auth()->id())
                )
            )
            ->filter(fn ($q) => $q->count())
            ->first()
            ?->first()
            ?->team
            ->id;
    }
}
