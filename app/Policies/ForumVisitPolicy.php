<?php

namespace App\Policies;

use App\Models\ForumVisit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumVisitPolicy
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

    public function view(User $user, ForumVisit $forumVisit): bool
    {
        return $user->id === $forumVisit->user_id;
    }

    public function create(User $user): bool
    {
        return $user->exists();
    }

    public function update(User $user, ForumVisit $forumVisit): bool
    {
        return $user->id === $forumVisit->user_id;
    }

    public function delete(User $user, ForumVisit $forumVisit): bool
    {
        return $user->id === $forumVisit->user_id;
    }
}
