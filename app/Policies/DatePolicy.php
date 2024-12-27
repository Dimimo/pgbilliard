<?php

namespace App\Policies;

use App\Models\Date;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DatePolicy
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

    public function update(User $user): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, date $dates): bool
    {
        return $user->isAdmin() && $dates->events->count() === 0;
    }
}
