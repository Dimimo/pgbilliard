<?php

namespace App\Policies;

use App\Models\date;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, date $dates): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, date $dates): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, date $dates): bool
    {
        return $user->isAdmin();
    }
}
