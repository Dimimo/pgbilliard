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

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Team $team): bool
    {
        return $this->returnAdminOwnerOrCaptain($user, $team);
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }

    private function returnAdminOwnerOrCaptain(User $user, Team $team): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($team->venue->owner?->id === $user->id) {
            return true;
        }

        return $team->players()->where('user_id', $user->id)->first()?->captain === true;
    }
}
