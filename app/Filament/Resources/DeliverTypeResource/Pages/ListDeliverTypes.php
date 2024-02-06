<?php

namespace App\Filament\Resources\DeliverTypeResource\Pages;

use App\Filament\Resources\DeliverTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliverTypes extends ListRecords
{
    protected static string $resource = DeliverTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
