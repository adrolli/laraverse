<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Stack;
use Illuminate\Auth\Access\HandlesAuthorization;

class StackPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the stack can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list stacks');
    }

    /**
     * Determine whether the stack can view the model.
     */
    public function view(User $user, Stack $model): bool
    {
        return $user->hasPermissionTo('view stacks');
    }

    /**
     * Determine whether the stack can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create stacks');
    }

    /**
     * Determine whether the stack can update the model.
     */
    public function update(User $user, Stack $model): bool
    {
        return $user->hasPermissionTo('update stacks');
    }

    /**
     * Determine whether the stack can delete the model.
     */
    public function delete(User $user, Stack $model): bool
    {
        return $user->hasPermissionTo('delete stacks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete stacks');
    }

    /**
     * Determine whether the stack can restore the model.
     */
    public function restore(User $user, Stack $model): bool
    {
        return false;
    }

    /**
     * Determine whether the stack can permanently delete the model.
     */
    public function forceDelete(User $user, Stack $model): bool
    {
        return false;
    }
}
