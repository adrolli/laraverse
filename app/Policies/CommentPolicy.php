<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the comment can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list comments');
    }

    /**
     * Determine whether the comment can view the model.
     */
    public function view(User $user, Comment $model): bool
    {
        return $user->hasPermissionTo('view comments');
    }

    /**
     * Determine whether the comment can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create comments');
    }

    /**
     * Determine whether the comment can update the model.
     */
    public function update(User $user, Comment $model): bool
    {
        return $user->hasPermissionTo('update comments');
    }

    /**
     * Determine whether the comment can delete the model.
     */
    public function delete(User $user, Comment $model): bool
    {
        return $user->hasPermissionTo('delete comments');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete comments');
    }

    /**
     * Determine whether the comment can restore the model.
     */
    public function restore(User $user, Comment $model): bool
    {
        return false;
    }

    /**
     * Determine whether the comment can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $model): bool
    {
        return false;
    }
}
