<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Owner;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the owner can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list owners');
    }

    /**
     * Determine whether the owner can view the model.
     */
    public function view(User $user, Owner $model): bool
    {
        return $user->hasPermissionTo('view owners');
    }

    /**
     * Determine whether the owner can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create owners');
    }

    /**
     * Determine whether the owner can update the model.
     */
    public function update(User $user, Owner $model): bool
    {
        return $user->hasPermissionTo('update owners');
    }

    /**
     * Determine whether the owner can delete the model.
     */
    public function delete(User $user, Owner $model): bool
    {
        return $user->hasPermissionTo('delete owners');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete owners');
    }

    /**
     * Determine whether the owner can restore the model.
     */
    public function restore(User $user, Owner $model): bool
    {
        return false;
    }

    /**
     * Determine whether the owner can permanently delete the model.
     */
    public function forceDelete(User $user, Owner $model): bool
    {
        return false;
    }
}
