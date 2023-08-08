<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Version;
use Illuminate\Auth\Access\HandlesAuthorization;

class VersionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the version can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list versions');
    }

    /**
     * Determine whether the version can view the model.
     */
    public function view(User $user, Version $model): bool
    {
        return $user->hasPermissionTo('view versions');
    }

    /**
     * Determine whether the version can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create versions');
    }

    /**
     * Determine whether the version can update the model.
     */
    public function update(User $user, Version $model): bool
    {
        return $user->hasPermissionTo('update versions');
    }

    /**
     * Determine whether the version can delete the model.
     */
    public function delete(User $user, Version $model): bool
    {
        return $user->hasPermissionTo('delete versions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete versions');
    }

    /**
     * Determine whether the version can restore the model.
     */
    public function restore(User $user, Version $model): bool
    {
        return false;
    }

    /**
     * Determine whether the version can permanently delete the model.
     */
    public function forceDelete(User $user, Version $model): bool
    {
        return false;
    }
}
