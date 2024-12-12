<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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

    public function update(User $user, Event $event): bool
    {
        return $user->isAdmin() || ($event->date->checkOpenWindowAccess() && $event->playerBelongsToEvent($user));
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->isAdmin() && $event->score1 === null && $event->score2 === null;
    }
}
