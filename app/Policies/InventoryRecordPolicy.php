<?php

namespace App\Policies;

use App\Models\InventoryRecord;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InventoryRecordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list inventory_records');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InventoryRecord $inventoryRecord): bool
    {
        return $user->authorized('view inventory_records');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create inventory_records');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InventoryRecord $inventoryRecord): bool
    {
        return $user->authorized('update inventory_records');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InventoryRecord $inventoryRecord): bool
    {
        return $user->authorized('delete inventory_records');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, InventoryRecord $inventoryRecord): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, InventoryRecord $inventoryRecord): bool
    {
        //
    }
}
