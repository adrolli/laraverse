<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the tag can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list tags');
    }

    /**
     * Determine whether the tag can view the model.
     */
    public function view(User $user, Tag $model): bool
    {
        return $user->hasPermissionTo('view tags');
    }

    /**
     * Determine whether the tag can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create tags');
    }

    /**
     * Determine whether the tag can update the model.
     */
    public function update(User $user, Tag $model): bool
    {
        return $user->hasPermissionTo('update tags');
    }

    /**
     * Determine whether the tag can delete the model.
     */
    public function delete(User $user, Tag $model): bool
    {
        return $user->hasPermissionTo('delete tags');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete tags');
    }

    /**
     * Determine whether the tag can restore the model.
     */
    public function restore(User $user, Tag $model): bool
    {
        return false;
    }

    /**
     * Determine whether the tag can permanently delete the model.
     */
    public function forceDelete(User $user, Tag $model): bool
    {
        return false;
    }
}
