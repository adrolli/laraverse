<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the item can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list items');
    }

    /**
     * Determine whether the item can view the model.
     */
    public function view(User $user, Item $model): bool
    {
        return $user->hasPermissionTo('view items');
    }

    /**
     * Determine whether the item can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create items');
    }

    /**
     * Determine whether the item can update the model.
     */
    public function update(User $user, Item $model): bool
    {
        return $user->hasPermissionTo('update items');
    }

    /**
     * Determine whether the item can delete the model.
     */
    public function delete(User $user, Item $model): bool
    {
        return $user->hasPermissionTo('delete items');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete items');
    }

    /**
     * Determine whether the item can restore the model.
     */
    public function restore(User $user, Item $model): bool
    {
        return false;
    }

    /**
     * Determine whether the item can permanently delete the model.
     */
    public function forceDelete(User $user, Item $model): bool
    {
        return false;
    }
}
