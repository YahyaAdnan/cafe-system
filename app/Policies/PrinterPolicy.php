<?php

namespace App\Policies;

use App\Models\Printer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrinterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list printers');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Printer $printer): bool
    {
        return $user->authorized('view printers');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create printers');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Printer $printer): bool
    {
        return $user->authorized('update printers');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Printer $printer): bool
    {
        return $user->authorized('delete printers');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Printer $printer): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Printer $printer): bool
    {
        //
    }
}
