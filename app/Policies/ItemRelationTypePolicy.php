<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ItemRelationType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemRelationTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the itemRelationType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list itemrelationtypes');
    }

    /**
     * Determine whether the itemRelationType can view the model.
     */
    public function view(User $user, ItemRelationType $model): bool
    {
        return $user->hasPermissionTo('view itemrelationtypes');
    }

    /**
     * Determine whether the itemRelationType can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create itemrelationtypes');
    }

    /**
     * Determine whether the itemRelationType can update the model.
     */
    public function update(User $user, ItemRelationType $model): bool
    {
        return $user->hasPermissionTo('update itemrelationtypes');
    }

    /**
     * Determine whether the itemRelationType can delete the model.
     */
    public function delete(User $user, ItemRelationType $model): bool
    {
        return $user->hasPermissionTo('delete itemrelationtypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete itemrelationtypes');
    }

    /**
     * Determine whether the itemRelationType can restore the model.
     */
    public function restore(User $user, ItemRelationType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the itemRelationType can permanently delete the model.
     */
    public function forceDelete(User $user, ItemRelationType $model): bool
    {
        return false;
    }
}
