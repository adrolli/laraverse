<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the post can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list posts');
    }

    /**
     * Determine whether the post can view the model.
     */
    public function view(User $user, Post $model): bool
    {
        return $user->hasPermissionTo('view posts');
    }

    /**
     * Determine whether the post can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create posts');
    }

    /**
     * Determine whether the post can update the model.
     */
    public function update(User $user, Post $model): bool
    {
        return $user->hasPermissionTo('update posts');
    }

    /**
     * Determine whether the post can delete the model.
     */
    public function delete(User $user, Post $model): bool
    {
        return $user->hasPermissionTo('delete posts');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete posts');
    }

    /**
     * Determine whether the post can restore the model.
     */
    public function restore(User $user, Post $model): bool
    {
        return false;
    }

    /**
     * Determine whether the post can permanently delete the model.
     */
    public function forceDelete(User $user, Post $model): bool
    {
        return false;
    }
}
