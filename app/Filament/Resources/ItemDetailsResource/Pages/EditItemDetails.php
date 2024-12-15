<?php

namespace App\Filament\Resources\ItemDetailsResource\Pages;

use App\Filament\Resources\ItemDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemDetails extends EditRecord
{
    protected static string $resource = ItemDetailsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
