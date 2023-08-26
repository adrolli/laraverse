<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Repository;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the repository can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list repositories');
    }

    /**
     * Determine whether the repository can view the model.
     */
    public function view(User $user, Repository $model): bool
    {
        return $user->hasPermissionTo('view repositories');
    }

    /**
     * Determine whether the repository can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create repositories');
    }

    /**
     * Determine whether the repository can update the model.
     */
    public function update(User $user, Repository $model): bool
    {
        return $user->hasPermissionTo('update repositories');
    }

    /**
     * Determine whether the repository can delete the model.
     */
    public function delete(User $user, Repository $model): bool
    {
        return $user->hasPermissionTo('delete repositories');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete repositories');
    }

    /**
     * Determine whether the repository can restore the model.
     */
    public function restore(User $user, Repository $model): bool
    {
        return false;
    }

    /**
     * Determine whether the repository can permanently delete the model.
     */
    public function forceDelete(User $user, Repository $model): bool
    {
        return false;
    }
}
