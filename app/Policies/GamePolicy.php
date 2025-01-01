<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(): bool
    {
        return true;
    }

    public function view(): bool
    {
        return true;
    }

    public function create(User $user, Event $event): bool
    {
        return $event->playerBelongsToEvent($user);
    }

    public function update(User $user, Event $event): bool
    {
        return $event->playerBelongsToEvent($user);
    }

    public function delete(User $user, Event $event): bool
    {
        return $event->playerBelongsToEvent($user);
    }
}
