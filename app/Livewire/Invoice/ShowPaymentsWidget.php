<?php

namespace App\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\Payment;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Widgets\TableWidget as BaseWidget;

class ShowPaymentsWidget extends BaseWidget
{
    public Invoice $invoice;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->invoice->payments()->getQuery())
            ->columns([
                Columns\TextColumn::make('paymentMethod.title')
                    ->summarize(Count::make())
                    ->sortable(),
                Columns\TextColumn::make('amount')
                    ->summarize(Sum::make())
                    ->money('IQD')
                    ->sortable(),
                Columns\TextColumn::make('paid')
                    ->summarize(Sum::make())
                    ->money('IQD')
                    ->toggleable()
                    ->sortable(),
                Columns\TextColumn::make('remaining')
                    ->summarize(Sum::make())
                    ->money('IQD')
                    ->toggleable()
                    ->sortable(),
                Columns\TextColumn::make('note')
                    ->toggleable()
                    ->sortable(),
            ])->actions([
                EditAction::make()
                    ->slideOver()
                    ->form([
                        TextInput::make('note')
                            ->columnSpan(12)
                            ->maxLength(64),
                    ]),
            ])
            ->paginated(false);
    }
}
