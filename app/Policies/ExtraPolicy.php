<?php

namespace App\Policies;

use App\Models\Extra;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ExtraPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list extras');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Extra $extra): bool
    {
        return $user->authorized('view extras');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create extras');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Extra $extra): bool
    {
        return $user->authorized('update extras');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Extra $extra): bool
    {
        return $user->authorized('delete extras');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Extra $extra): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Extra $extra): bool
    {
        //
    }
}
