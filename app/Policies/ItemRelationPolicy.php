<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ItemRelation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemRelationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the itemRelation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list itemrelations');
    }

    /**
     * Determine whether the itemRelation can view the model.
     */
    public function view(User $user, ItemRelation $model): bool
    {
        return $user->hasPermissionTo('view itemrelations');
    }

    /**
     * Determine whether the itemRelation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create itemrelations');
    }

    /**
     * Determine whether the itemRelation can update the model.
     */
    public function update(User $user, ItemRelation $model): bool
    {
        return $user->hasPermissionTo('update itemrelations');
    }

    /**
     * Determine whether the itemRelation can delete the model.
     */
    public function delete(User $user, ItemRelation $model): bool
    {
        return $user->hasPermissionTo('delete itemrelations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete itemrelations');
    }

    /**
     * Determine whether the itemRelation can restore the model.
     */
    public function restore(User $user, ItemRelation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the itemRelation can permanently delete the model.
     */
    public function forceDelete(User $user, ItemRelation $model): bool
    {
        return false;
    }
}
