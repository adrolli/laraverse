<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GithubOwner;
use Illuminate\Auth\Access\HandlesAuthorization;

class GithubOwnerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the githubOwner can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list githubowners');
    }

    /**
     * Determine whether the githubOwner can view the model.
     */
    public function view(User $user, GithubOwner $model): bool
    {
        return $user->hasPermissionTo('view githubowners');
    }

    /**
     * Determine whether the githubOwner can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create githubowners');
    }

    /**
     * Determine whether the githubOwner can update the model.
     */
    public function update(User $user, GithubOwner $model): bool
    {
        return $user->hasPermissionTo('update githubowners');
    }

    /**
     * Determine whether the githubOwner can delete the model.
     */
    public function delete(User $user, GithubOwner $model): bool
    {
        return $user->hasPermissionTo('delete githubowners');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete githubowners');
    }

    /**
     * Determine whether the githubOwner can restore the model.
     */
    public function restore(User $user, GithubOwner $model): bool
    {
        return false;
    }

    /**
     * Determine whether the githubOwner can permanently delete the model.
     */
    public function forceDelete(User $user, GithubOwner $model): bool
    {
        return false;
    }
}
