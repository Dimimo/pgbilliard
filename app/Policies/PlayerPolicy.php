<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(User $user, Team $team): bool
    {
        return $this->returnAdminOwnerOrCaptain($user, $team);
    }

    public function update(User $user, Player $player): bool
    {
        if ($this->returnAdminOwnerOrCaptain($user, $player->team)) {
            return true;
        }

        return $user->id === $player->user_id;
    }

    public function delete(User $user, Player $player): bool
    {
        return $this->returnAdminOwnerOrCaptain($user, $player->team);
    }

    private function returnAdminOwnerOrCaptain(User $user, Team $team): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($team->venue->owner->id === $user->id) {
            return true;
        }

        return $team->activePlayers()->where('user_id', $user->id)->first()?->captain === true;
    }
}
