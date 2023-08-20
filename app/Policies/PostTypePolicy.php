<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PostType;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the postType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list posttypes');
    }

    /**
     * Determine whether the postType can view the model.
     */
    public function view(User $user, PostType $model): bool
    {
        return $user->hasPermissionTo('view posttypes');
    }

    /**
     * Determine whether the postType can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create posttypes');
    }

    /**
     * Determine whether the postType can update the model.
     */
    public function update(User $user, PostType $model): bool
    {
        return $user->hasPermissionTo('update posttypes');
    }

    /**
     * Determine whether the postType can delete the model.
     */
    public function delete(User $user, PostType $model): bool
    {
        return $user->hasPermissionTo('delete posttypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete posttypes');
    }

    /**
     * Determine whether the postType can restore the model.
     */
    public function restore(User $user, PostType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the postType can permanently delete the model.
     */
    public function forceDelete(User $user, PostType $model): bool
    {
        return false;
    }
}
