<?php

namespace App\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\Order;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Orders extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public Invoice $invoice;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }   

        
    public function table(Table $table): Table
    {
        return $table
            ->query($this->invoice->orders()->getQuery())
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->money('IQD')
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('IQD')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('discount_fixed')
                    ->money('IQD')
                    ->label('discount')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('note')
                    ->toggleable()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make()
                    ->slideOver()
                    ->form([
                        TextInput::make('discount_fixed')
                            ->numeric()
                            ->label('discount')
                            ->suffix('IQD')
                            ->minValue(0)
                            ->maxValue(function (Order $order)  {
                                return $order->amount;
                            }),
                        TextInput::make('note')
                            ->columnSpan(12)
                            ->maxLength(64),
                    ]),
            ])
            ->paginated(false);
    }

    public function render()
    {
        return view('livewire.invoice.orders');
    }
}
