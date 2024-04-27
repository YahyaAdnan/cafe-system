<?php

namespace App\Policies;

use App\Models\DeliverType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DeliverTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list deliver_types');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DeliverType $deliverType): bool
    {
        return $user->authorized('view deliver_types');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create deliver_types');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DeliverType $deliverType): bool
    {
        return $user->authorized('update deliver_types');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DeliverType $deliverType): bool
    {
        return $user->authorized('delete deliver_types');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DeliverType $deliverType): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DeliverType $deliverType): bool
    {
        //
    }
}
