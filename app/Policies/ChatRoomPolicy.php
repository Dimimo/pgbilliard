<?php

namespace App\Policies;

use App\Models\Chat\ChatRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatRoomPolicy
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

    public function view(User $user, ChatRoom $chatRoom): bool
    {
        if (! $chatRoom->private) {
            return true;
        }

        return $user->id === $chatRoom->user_id || $chatRoom->users()->whereId($user->id)->count() === 1;
    }

    public function create(User $user): bool
    {
        return $user->exists();
    }

    public function update(User $user, ChatRoom $chatRoom): bool
    {
        return $user->id === $chatRoom->user_id;
    }

    public function delete(User $user, ChatRoom $chatRoom): bool
    {
        if ($chatRoom->id === 1 ) {
            return false;
        }
        return $user->id === $chatRoom->user_id;
    }
}
