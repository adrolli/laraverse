<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GithubRepo;
use Illuminate\Auth\Access\HandlesAuthorization;

class GithubRepoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the githubRepo can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list githubrepos');
    }

    /**
     * Determine whether the githubRepo can view the model.
     */
    public function view(User $user, GithubRepo $model): bool
    {
        return $user->hasPermissionTo('view githubrepos');
    }

    /**
     * Determine whether the githubRepo can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create githubrepos');
    }

    /**
     * Determine whether the githubRepo can update the model.
     */
    public function update(User $user, GithubRepo $model): bool
    {
        return $user->hasPermissionTo('update githubrepos');
    }

    /**
     * Determine whether the githubRepo can delete the model.
     */
    public function delete(User $user, GithubRepo $model): bool
    {
        return $user->hasPermissionTo('delete githubrepos');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete githubrepos');
    }

    /**
     * Determine whether the githubRepo can restore the model.
     */
    public function restore(User $user, GithubRepo $model): bool
    {
        return false;
    }

    /**
     * Determine whether the githubRepo can permanently delete the model.
     */
    public function forceDelete(User $user, GithubRepo $model): bool
    {
        return false;
    }
}
