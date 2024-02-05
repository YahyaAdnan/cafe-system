<?php

namespace App\Filament\Resources\DailySaleResource\Pages;

use App\Filament\Resources\DailySaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDailySale extends CreateRecord
{
    protected static string $resource = DailySaleResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
