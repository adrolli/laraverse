<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GithubOrganization;
use Illuminate\Auth\Access\HandlesAuthorization;

class GithubOrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the githubOrganization can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list githuborganizations');
    }

    /**
     * Determine whether the githubOrganization can view the model.
     */
    public function view(User $user, GithubOrganization $model): bool
    {
        return $user->hasPermissionTo('view githuborganizations');
    }

    /**
     * Determine whether the githubOrganization can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create githuborganizations');
    }

    /**
     * Determine whether the githubOrganization can update the model.
     */
    public function update(User $user, GithubOrganization $model): bool
    {
        return $user->hasPermissionTo('update githuborganizations');
    }

    /**
     * Determine whether the githubOrganization can delete the model.
     */
    public function delete(User $user, GithubOrganization $model): bool
    {
        return $user->hasPermissionTo('delete githuborganizations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete githuborganizations');
    }

    /**
     * Determine whether the githubOrganization can restore the model.
     */
    public function restore(User $user, GithubOrganization $model): bool
    {
        return false;
    }

    /**
     * Determine whether the githubOrganization can permanently delete the model.
     */
    public function forceDelete(User $user, GithubOrganization $model): bool
    {
        return false;
    }
}
