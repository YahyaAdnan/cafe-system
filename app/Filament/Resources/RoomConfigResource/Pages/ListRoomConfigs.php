<?php

namespace App\Filament\Resources\RoomConfigResource\Pages;

use App\Filament\Resources\RoomConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRoomConfigs extends ListRecords
{
    protected static string $resource = RoomConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
