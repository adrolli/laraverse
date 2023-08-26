<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RepositoryTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoryTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the repositoryTag can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list repositorytags');
    }

    /**
     * Determine whether the repositoryTag can view the model.
     */
    public function view(User $user, RepositoryTag $model): bool
    {
        return $user->hasPermissionTo('view repositorytags');
    }

    /**
     * Determine whether the repositoryTag can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create repositorytags');
    }

    /**
     * Determine whether the repositoryTag can update the model.
     */
    public function update(User $user, RepositoryTag $model): bool
    {
        return $user->hasPermissionTo('update repositorytags');
    }

    /**
     * Determine whether the repositoryTag can delete the model.
     */
    public function delete(User $user, RepositoryTag $model): bool
    {
        return $user->hasPermissionTo('delete repositorytags');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete repositorytags');
    }

    /**
     * Determine whether the repositoryTag can restore the model.
     */
    public function restore(User $user, RepositoryTag $model): bool
    {
        return false;
    }

    /**
     * Determine whether the repositoryTag can permanently delete the model.
     */
    public function forceDelete(User $user, RepositoryTag $model): bool
    {
        return false;
    }
}
