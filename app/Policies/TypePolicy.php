<?php

namespace App\Policies;

use App\Models\Type;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the type can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list types');
    }

    /**
     * Determine whether the type can view the model.
     */
    public function view(User $user, Type $model): bool
    {
        return $user->hasPermissionTo('view types');
    }

    /**
     * Determine whether the type can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create types');
    }

    /**
     * Determine whether the type can update the model.
     */
    public function update(User $user, Type $model): bool
    {
        return $user->hasPermissionTo('update types');
    }

    /**
     * Determine whether the type can delete the model.
     */
    public function delete(User $user, Type $model): bool
    {
        return $user->hasPermissionTo('delete types');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete types');
    }

    /**
     * Determine whether the type can restore the model.
     */
    public function restore(User $user, Type $model): bool
    {
        return false;
    }

    /**
     * Determine whether the type can permanently delete the model.
     */
    public function forceDelete(User $user, Type $model): bool
    {
        return false;
    }
}
