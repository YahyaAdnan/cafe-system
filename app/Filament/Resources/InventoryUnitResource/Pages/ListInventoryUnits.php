<?php

namespace App\Filament\Resources\InventoryUnitResource\Pages;

use App\Filament\Resources\InventoryUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventoryUnits extends ListRecords
{
    protected static string $resource = InventoryUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
