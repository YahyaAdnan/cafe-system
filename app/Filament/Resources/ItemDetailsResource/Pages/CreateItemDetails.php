<?php

namespace App\Filament\Resources\ItemDetailsResource\Pages;

use App\Filament\Resources\ItemDetailsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateItemDetails extends CreateRecord
{
    protected static string $resource = ItemDetailsResource::class;
}
