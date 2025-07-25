<?php

namespace App\Policies;

use App\Models\DailySale;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DailySalePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list daily_sales');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DailySale $dailySale): bool
    {
        return $user->authorized('view daily_sales');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create daily_sales');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DailySale $dailySale): bool
    {
        return $user->authorized('update daily_sales');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DailySale $dailySale): bool
    {
        return $user->authorized('delete daily_sales');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DailySale $dailySale): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DailySale $dailySale): bool
    {
        //
    }
}
