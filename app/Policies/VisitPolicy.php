<?php

namespace App\Policies;

use App\Models\Forum\Visit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisitPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->exists();
    }

    public function view(User $user, Visit $visit): bool
    {
        return $user->id === $visit->user_id;
    }

    public function create(User $user): bool
    {
        return $user->exists();
    }

    public function update(User $user, Visit $visit): bool
    {
        return $user->id === $visit->user_id;
    }

    public function delete(User $user, Visit $visit): bool
    {
        return $user->id === $visit->user_id;
    }
}
