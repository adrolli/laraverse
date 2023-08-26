<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PackagistPackage;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagistPackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the packagistPackage can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list packagistpackages');
    }

    /**
     * Determine whether the packagistPackage can view the model.
     */
    public function view(User $user, PackagistPackage $model): bool
    {
        return $user->hasPermissionTo('view packagistpackages');
    }

    /**
     * Determine whether the packagistPackage can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create packagistpackages');
    }

    /**
     * Determine whether the packagistPackage can update the model.
     */
    public function update(User $user, PackagistPackage $model): bool
    {
        return $user->hasPermissionTo('update packagistpackages');
    }

    /**
     * Determine whether the packagistPackage can delete the model.
     */
    public function delete(User $user, PackagistPackage $model): bool
    {
        return $user->hasPermissionTo('delete packagistpackages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete packagistpackages');
    }

    /**
     * Determine whether the packagistPackage can restore the model.
     */
    public function restore(User $user, PackagistPackage $model): bool
    {
        return false;
    }

    /**
     * Determine whether the packagistPackage can permanently delete the model.
     */
    public function forceDelete(User $user, PackagistPackage $model): bool
    {
        return false;
    }
}
