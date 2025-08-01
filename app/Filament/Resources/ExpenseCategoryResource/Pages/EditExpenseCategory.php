<?php

namespace App\Filament\Resources\ExpenseCategoryResource\Pages;

use App\Models\ExpenseCategory;
use App\Filament\Resources\ExpenseCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpenseCategory extends EditRecord
{
    protected static string $resource = ExpenseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(ExpenseCategory $expenseCategory) => !$expenseCategory->isDeletable()),
        ];
    }
}
