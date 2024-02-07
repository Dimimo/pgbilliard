<?php

namespace App\Policies;

use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPostPolicy
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

    public function create(User $user): bool
    {
        return $user->exists();
    }

    public function update(User $user, ForumPost $forumPost): bool
    {
        return $user->id === $forumPost->user_id;
    }

    public function delete(User $user, ForumPost $forumPost): bool
    {
        return $user->id === $forumPost->user_id;
    }
}
