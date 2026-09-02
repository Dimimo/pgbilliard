<?php

namespace App\Policies;

use App\Models\Season;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeasonPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(?User $user): bool
    {
        return Season::query()->visibleTo($user)->exists();
    }

    public function view(?User $user, Season $season): bool
    {
        return $season->isVisibleTo($user);
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Season $season): bool
    {
        return $user->isAdmin() &&
            $season->teams()->count() === 0 &&
            $season->dates()->count() === 0;
    }
}
