<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Models\Expense;
use App\Filament\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpense extends EditRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(Expense $expense) => !$expense->isDeletable()),
        ];
    }
}
