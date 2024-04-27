<?php

namespace App\Policies;

use App\Models\InventoryUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventoryUnitPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list inventory_units');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InventoryUnit $inventoryUnit): bool
    {
        return $user->authorized('view inventory_units');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create inventory_units');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InventoryUnit $inventoryUnit): bool
    {
        return $user->authorized('update inventory_units');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InventoryUnit $inventoryUnit): bool
    {
        return $user->authorized('delete inventory_units');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InventoryUnit $inventoryUnit): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InventoryUnit $inventoryUnit): bool
    {
        //
    }
}
