<?php

namespace App\Filament\Resources\ItemTypeResource\Pages;

use App\Models\Item;
use App\Filament\Resources\ItemTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItemType extends EditRecord
{
    protected static string $resource = ItemTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(Item $item) => !$item->isDeletable()),
        ];
    }
}
