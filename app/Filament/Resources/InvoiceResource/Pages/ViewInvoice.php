<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Livewire;
use App\Livewire\Cashier\Invoice;
use App\Livewire\Invoice\Card;
use Filament\Infolists\Components\TextEntry;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Livewire::make(Card::class)->columnSpanFull(),
                Livewire::make(Invoice::class)->columnSpanFull(),
            ]);
    }
}
