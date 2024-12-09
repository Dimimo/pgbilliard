<?php

namespace App\Policies;

use App\Models\Format;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FormatPolicy
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
        return $user->isAdmin();
    }

    public function update(User $user, Format $format): bool
    {
        return $user->id === $format->user_id;
    }

    public function delete(User $user, Format $format): bool
    {
        return $user->id === $format->user_id;
    }
}
