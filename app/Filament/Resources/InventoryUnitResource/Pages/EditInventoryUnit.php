<?php

namespace App\Filament\Resources\InventoryUnitResource\Pages;

use App\Models\InventoryUnit;
use App\Filament\Resources\InventoryUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryUnit extends EditRecord
{
    protected static string $resource = InventoryUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(InventoryUnit $inventoryUnit) => !$inventoryUnit->isDeletable()),
        ];
    }
}
