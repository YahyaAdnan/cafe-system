<?php

namespace App\Policies;

use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ExpenseCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list expense_categories');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExpenseCategory $expenseCategory): bool
    {
        return $user->authorized('view expense_categories');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create expense_categories');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExpenseCategory $expenseCategory): bool
    {
        return $user->authorized('update expense_categories');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExpenseCategory $expenseCategory): bool
    {
        return $user->authorized('delete expense_categories');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ExpenseCategory $expenseCategory): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ExpenseCategory $expenseCategory): bool
    {
        //
    }
}
