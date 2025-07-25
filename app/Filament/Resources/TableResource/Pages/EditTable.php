<?php

namespace App\Filament\Resources\TableResource\Pages;

use App\Models\Table;
use App\Filament\Resources\TableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTable extends EditRecord
{
    protected static string $resource = TableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(Table $table) => !$table->isDeletable()),
        ];
    }
}
