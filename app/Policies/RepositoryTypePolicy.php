<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RepositoryType;
use Illuminate\Auth\Access\HandlesAuthorization;

class RepositoryTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the repositoryType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list repositorytypes');
    }

    /**
     * Determine whether the repositoryType can view the model.
     */
    public function view(User $user, RepositoryType $model): bool
    {
        return $user->hasPermissionTo('view repositorytypes');
    }

    /**
     * Determine whether the repositoryType can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create repositorytypes');
    }

    /**
     * Determine whether the repositoryType can update the model.
     */
    public function update(User $user, RepositoryType $model): bool
    {
        return $user->hasPermissionTo('update repositorytypes');
    }

    /**
     * Determine whether the repositoryType can delete the model.
     */
    public function delete(User $user, RepositoryType $model): bool
    {
        return $user->hasPermissionTo('delete repositorytypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete repositorytypes');
    }

    /**
     * Determine whether the repositoryType can restore the model.
     */
    public function restore(User $user, RepositoryType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the repositoryType can permanently delete the model.
     */
    public function forceDelete(User $user, RepositoryType $model): bool
    {
        return false;
    }
}
