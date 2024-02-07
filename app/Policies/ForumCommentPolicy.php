<?php

namespace App\Policies;

use App\Models\ForumComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumCommentPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAdmin())
        {
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

    public function create(User $user): bool
    {
        return $user->exists();
    }

    public function update(User $user, ForumComment $forumComment): bool
    {
        return $user->id === $forumComment->user_id;
    }

    public function delete(User $user, ForumComment $forumComment): bool
    {
        return $user->id === $forumComment->user_id;
    }
}
