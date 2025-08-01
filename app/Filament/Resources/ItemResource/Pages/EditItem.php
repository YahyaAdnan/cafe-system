<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Models\Item;
use App\Filament\Resources\ItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditItem extends EditRecord
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->disabled(fn(Item $item) => !$item->isDeletable()),
        ];
    }
}
