<?php

namespace App\Livewire\Invoice;

use App\Models\Invoice;
use App\Models\Order;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Table;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\InvoiceAction;
use App\Services\PaymentService;

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
                    ->disabled(!$this->invoice->active)
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
            ->headerActions([
                    PaymentService::showPayments($this->invoice),
                    PaymentService::createPayemnt($this->invoice),
                ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->visible(fn() => Auth::user()->authorized('delete orders'))
                        ->color('danger')
                        ->action(function(Collection $records){
                            foreach ($records as $key => $order) 
                            {
                                $order->delete();
                            }
                            Invoice::find($this->invoice->id)->updateAmount();
                            return redirect("invoices/". $this->invoice->id);
                        }),
                    BulkAction::make('Move')
                        ->form([
                            Select::make('invoice')
                                ->required()
                                ->searchable()
                                ->options(Invoice::fetchActive())
                        ])
                        ->action(function(Collection $records, array $data){
                            $invoice = InvoiceAction::move([
                                'orders' => $records,
                                'to' => $data['invoice'],
                            ]);
                            return redirect("invoices/$invoice->id");
                        })
                        ->color('info'),
                    BulkAction::make('Split')
                        ->action(function (Collection $records) {
                            $new_inovice = InvoiceAction::split([
                                'orders' => $records,
                                'invoice' => $this->invoice
                            ]);
                            return redirect("invoices/$new_inovice->id");
                        })
                        ->color('warning')
                ]),
            ])->checkIfRecordIsSelectableUsing(
                fn() => $this->invoice->remaining == $this->invoice->amount 
            )
            ->paginated(false);
    }

    public function render()
    {
        return view('livewire.invoice.orders');
    }
}
