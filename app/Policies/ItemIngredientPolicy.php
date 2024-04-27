<?php

namespace App\Policies;

use App\Models\ItemIngredient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemIngredientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list item_ingredients');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ItemIngredient $itemIngredient): bool
    {
        return $user->authorized('view item_ingredients');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create item_ingredients');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ItemIngredient $itemIngredient): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ItemIngredient $itemIngredient): bool
    {
        return $user->authorized('update item_ingredients');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ItemIngredient $itemIngredient): bool
    {
        return $user->authorized('delete item_ingredients');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ItemIngredient $itemIngredient): bool
    {
        //
    }
}
