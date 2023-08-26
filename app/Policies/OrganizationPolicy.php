<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the organization can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list organizations');
    }

    /**
     * Determine whether the organization can view the model.
     */
    public function view(User $user, Organization $model): bool
    {
        return $user->hasPermissionTo('view organizations');
    }

    /**
     * Determine whether the organization can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create organizations');
    }

    /**
     * Determine whether the organization can update the model.
     */
    public function update(User $user, Organization $model): bool
    {
        return $user->hasPermissionTo('update organizations');
    }

    /**
     * Determine whether the organization can delete the model.
     */
    public function delete(User $user, Organization $model): bool
    {
        return $user->hasPermissionTo('delete organizations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete organizations');
    }

    /**
     * Determine whether the organization can restore the model.
     */
    public function restore(User $user, Organization $model): bool
    {
        return false;
    }

    /**
     * Determine whether the organization can permanently delete the model.
     */
    public function forceDelete(User $user, Organization $model): bool
    {
        return false;
    }
}
