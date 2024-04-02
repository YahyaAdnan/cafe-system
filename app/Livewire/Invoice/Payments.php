<?php

namespace App\Livewire\Invoice;

use App\Models\PaymentMethod;
use App\Models\Invoice;
use App\Models\Order;
use Filament\Forms\Get;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Count;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Payments extends Component implements HasForms, HasTable
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
            ->query($this->invoice->payments()->getQuery())
            ->columns([
                TextColumn::make('paymentMethod.title')
                    ->summarize(Count::make())
                    ->sortable(),
                TextColumn::make('amount')
                    ->summarize(Sum::make())
                    ->money('IQD')
                    ->sortable(),
                TextColumn::make('paid')
                    ->summarize(Sum::make())
                    ->money('IQD')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('remaining')
                    ->summarize(Sum::make())
                    ->money('IQD')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('note')
                    ->toggleable()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        Fieldset::make('Payment')
                        ->schema([
                            Hidden::make('invoice_id')
                                ->default($this->invoice->id),
                            Select::make('payment_method_id')
                                ->columnSpan(12)
                                ->native(false)
                                ->options(PaymentMethod::pluck('title', 'id'))
                                ->required(),
                            TextInput::make('amount')
                                ->default(fn() => $this->invoice->remaining)
                                ->columnSpan([
                                    'sm' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ])
                                ->suffix("IQD")
                                ->numeric()
                                ->required()
                                ->minValue(1)
                                ->maxValue(fn() => $this->invoice->remaining)
                                ->live(),
                            TextInput::make('paid')
                                ->columnSpan([
                                    'sm' => 12,
                                    'md' => 6,
                                    'lg' => 4,
                                ])
                                ->suffix("IQD")
                                ->numeric()
                                ->required()
                                ->minValue(fn (Get $get) => $get('amount'))
                                ->maxValue(10000000)
                                ->live(),
                            Placeholder::make('Return')
                                ->content(function (Get $get)  {
                                    try {
                                        return number_format($get('paid') - $get('amount')) . ' IQD';
                                    } catch (\Throwable $th) {
                                        return '0 IQD';
                                    }
                                })
                                ->columnSpan(['sm' => 12, 'md' => 12, 'lg' => 4]),
                            TextInput::make('note')
                                ->columnSpan(12)
                                ->maxLength(64),
                        ])
                        ->columns(12),
                    ]),
            ])
            ->actions([
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

    public function render()
    {
        return view('livewire.invoice.payments');
    }
}
