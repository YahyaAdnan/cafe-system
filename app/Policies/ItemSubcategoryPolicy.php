<?php

namespace App\Policies;

use App\Models\ItemSubcategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemSubcategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list item_subcategories');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ItemSubcategory $itemSubcategory): bool
    {
        return $user->authorized('view item_subcategories');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create item_subcategories');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ItemSubcategory $itemSubcategory): bool
    {
        return $user->authorized('update item_subcategories');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ItemSubcategory $itemSubcategory): bool
    {
        return $user->authorized('delete item_subcategories');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ItemSubcategory $itemSubcategory): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ItemSubcategory $itemSubcategory): bool
    {
        //
    }
}
