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
        return false;
    }

    public function view(User $user, ChatRoom $chatRoom): bool
    {
        if ($chatRoom->private === 0) {
            return true;
        }

        return $chatRoom->users->contains($user);
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
        return $user->id === $chatRoom->user_id;
    }
}
