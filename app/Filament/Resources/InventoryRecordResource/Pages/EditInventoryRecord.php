<?php

namespace App\Filament\Resources\InventoryRecordResource\Pages;

use App\Filament\Resources\InventoryRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryRecord extends EditRecord
{
    protected static string $resource = InventoryRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
