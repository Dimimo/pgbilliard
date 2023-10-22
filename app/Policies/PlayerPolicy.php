<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlayerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Player $player): bool
    {
        return true;
    }

    public function create(User $user, Team $team): bool
    {
        return $this->returnAdminOrCaptain($user, $team);
    }

    public function update(User $user, Player $player): bool
    {
        if ($this->returnAdminOrCaptain($user, $player->team)) {
            return true;
        }
        return $user->id === $player->user_id;
    }

    public function delete(User $user, Player $player): bool
    {
        return $this->returnAdminOrCaptain($user, $player->team);
    }

    private function returnAdminOrCaptain(User $user, Team $team): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $team->players()->whereUserId($user->id)->first()->isCaptain($team);
    }
}
