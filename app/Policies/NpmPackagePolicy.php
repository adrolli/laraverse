<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NpmPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class NpmPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the npmPackage can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list npmpackages');
    }

    /**
     * Determine whether the npmPackage can view the model.
     */
    public function view(User $user, NpmPackage $model): bool
    {
        return $user->hasPermissionTo('view npmpackages');
    }

    /**
     * Determine whether the npmPackage can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create npmpackages');
    }

    /**
     * Determine whether the npmPackage can update the model.
     */
    public function update(User $user, NpmPackage $model): bool
    {
        return $user->hasPermissionTo('update npmpackages');
    }

    /**
     * Determine whether the npmPackage can delete the model.
     */
    public function delete(User $user, NpmPackage $model): bool
    {
        return $user->hasPermissionTo('delete npmpackages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete npmpackages');
    }

    /**
     * Determine whether the npmPackage can restore the model.
     */
    public function restore(User $user, NpmPackage $model): bool
    {
        return false;
    }

    /**
     * Determine whether the npmPackage can permanently delete the model.
     */
    public function forceDelete(User $user, NpmPackage $model): bool
    {
        return false;
    }
}
