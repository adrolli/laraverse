<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ItemType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the itemType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list itemtypes');
    }

    /**
     * Determine whether the itemType can view the model.
     */
    public function view(User $user, ItemType $model): bool
    {
        return $user->hasPermissionTo('view itemtypes');
    }

    /**
     * Determine whether the itemType can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create itemtypes');
    }

    /**
     * Determine whether the itemType can update the model.
     */
    public function update(User $user, ItemType $model): bool
    {
        return $user->hasPermissionTo('update itemtypes');
    }

    /**
     * Determine whether the itemType can delete the model.
     */
    public function delete(User $user, ItemType $model): bool
    {
        return $user->hasPermissionTo('delete itemtypes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete itemtypes');
    }

    /**
     * Determine whether the itemType can restore the model.
     */
    public function restore(User $user, ItemType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the itemType can permanently delete the model.
     */
    public function forceDelete(User $user, ItemType $model): bool
    {
        return false;
    }
}
