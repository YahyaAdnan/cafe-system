<?php

namespace App\Policies;

use App\Models\ItemType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list item_types');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ItemType $itemType): bool
    {
        return $user->authorized('view item_types');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create item_types');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ItemType $itemType): bool
    {
        return $user->authorized('update item_types');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ItemType $itemType): bool
    {
        return $user->authorized('delete item_types');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ItemType $itemType): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ItemType $itemType): bool
    {
        //
    }
}
