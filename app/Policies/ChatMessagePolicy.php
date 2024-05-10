<?php

namespace App\Policies;

use App\Models\Chat\ChatMessage;
use App\Models\Chat\ChatRoom;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatMessagePolicy
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

    public function view(User $user, ChatMessage $chatMessage): bool
    {
        if ($chatMessage->room->private === 0) {
            return true;
        }

        return $chatMessage->room->users->contains($user);
    }

    public function create(User $user, ChatRoom $chatRoom): bool
    {
        // this is a bit special. A chatroom can be public, then true, if private, only on invitation
        if ($chatRoom->private === false) {
            return true;
        }

        return $chatRoom->users()->whereId($user->id)->count() === 1;
    }

    public function update(User $user, ChatMessage $chatMessage): bool
    {
        return $user->id === $chatMessage->user_id;
    }

    public function delete(User $user, ChatMessage $chatMessage): bool
    {
        if ($user->id === $chatMessage->room->user_id) {
            return true;
        }

        return $user->id === $chatMessage->user_id;
    }
}
