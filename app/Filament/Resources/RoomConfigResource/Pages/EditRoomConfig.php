<?php

namespace App\Filament\Resources\RoomConfigResource\Pages;

use App\Filament\Resources\RoomConfigResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRoomConfig extends EditRecord
{
    protected static string $resource = RoomConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
