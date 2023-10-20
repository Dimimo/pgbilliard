<?php

namespace App\Policies;

use App\Models\Season;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeasonPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Season $season): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Season $season): bool
    {
    }

    public function delete(User $user, Season $season): bool
    {
    }

    public function restore(User $user, Season $season): bool
    {
    }

    public function forceDelete(User $user, Season $season): bool
    {
    }
}
