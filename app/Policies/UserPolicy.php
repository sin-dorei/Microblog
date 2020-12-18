<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    public function forceDelete(User $user, User $model)
    {
        return $user->is_admin && $user->id !== $model->id;
    }

    public function follow(User $user, User $model)
    {
        return $user->id !== $model->id;
    }
}
