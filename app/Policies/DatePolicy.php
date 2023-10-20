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

    }

    public function view(User $user, date $dates): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, date $dates): bool
    {
    }

    public function delete(User $user, date $dates): bool
    {
    }

    public function restore(User $user, date $dates): bool
    {
    }

    public function forceDelete(User $user, date $dates): bool
    {
    }
}
