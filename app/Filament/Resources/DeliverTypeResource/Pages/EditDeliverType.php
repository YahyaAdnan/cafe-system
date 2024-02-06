<?php

namespace App\Filament\Resources\DeliverTypeResource\Pages;

use App\Filament\Resources\DeliverTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliverType extends EditRecord
{
    protected static string $resource = DeliverTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
