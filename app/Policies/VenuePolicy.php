<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Venue;
use Illuminate\Auth\Access\HandlesAuthorization;

class VenuePolicy
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

    public function update(User $user, Venue $venue): bool
    {
        // the owner can update his own venue
        return $user->isAdmin() || $user->id === $venue->owner?->id;
    }

    public function delete(User $user, Venue $venue): bool
    {
        // make sure the venue has no teams first, only accidentally created venues can be deleted
        if ($venue->has('teams')) {
            return false;
        }

        return $user->isAdmin();
    }
}
