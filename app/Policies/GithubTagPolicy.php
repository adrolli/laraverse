<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GithubTag;
use Illuminate\Auth\Access\HandlesAuthorization;

class GithubTagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the githubTag can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list githubtags');
    }

    /**
     * Determine whether the githubTag can view the model.
     */
    public function view(User $user, GithubTag $model): bool
    {
        return $user->hasPermissionTo('view githubtags');
    }

    /**
     * Determine whether the githubTag can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create githubtags');
    }

    /**
     * Determine whether the githubTag can update the model.
     */
    public function update(User $user, GithubTag $model): bool
    {
        return $user->hasPermissionTo('update githubtags');
    }

    /**
     * Determine whether the githubTag can delete the model.
     */
    public function delete(User $user, GithubTag $model): bool
    {
        return $user->hasPermissionTo('delete githubtags');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete githubtags');
    }

    /**
     * Determine whether the githubTag can restore the model.
     */
    public function restore(User $user, GithubTag $model): bool
    {
        return false;
    }

    /**
     * Determine whether the githubTag can permanently delete the model.
     */
    public function forceDelete(User $user, GithubTag $model): bool
    {
        return false;
    }
}
