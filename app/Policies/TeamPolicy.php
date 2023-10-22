<?php

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
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
        return $user->isAdmin();
    }

    public function update(User $user, Team $team): bool
    {
        return $this->returnAdminOrCaptain($user, $team);
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->isAdmin();
    }

    private function returnAdminOrCaptain(User $user, Team $team): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $team->players()->whereUserId($user->id)->first()->isCaptain($team);
    }
}
