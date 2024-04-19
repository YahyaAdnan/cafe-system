<?php

namespace App\Livewire\Invoice;

use App\Models\Extra;
use App\Models\Order;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\Item;
use Filament\Forms\Get;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NewOrders extends Component implements HasForms
{
    use InteractsWithForms;

    // MODEL.
    public Invoice $invoice;

    public ?array $data = [];

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('orders')
                ->label('')
                ->schema([
                    Toggle::make('special_order')
                        ->inline()
                        ->columnSpan(12)
                        ->live(),
                    Select::make('item_id')
                        ->visible(fn (Get $get)=>  !$get('special_order'))
                        ->searchable()
                        ->columnSpan(['sm' => 12, 'md' => 6, 'xl' => 3])
                        ->options(Price::activePrices())
                        ->required()
                        ->live(),
                    TextInput::make('title')
                        ->visible(fn (Get $get)=>  $get('special_order'))
                        ->columnSpan(['sm' => 12, 'md' => 6, 'xl' => 3])
                        ->minLength(1)
                        ->maxLength(32)
                        ->required(),
                    TextInput::make('quantity')
                        ->numeric()
                        ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3])
                        ->default(1)
                        ->minValue(1)
                        ->maxValue(99)
                        ->required()
                        ->live(),
                    TextInput::make('amount')
                        ->visible(fn (Get $get)=>  $get('special_order'))
                        ->numeric()
                        ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3])
                        ->minValue(1)
                        ->maxValue(100000000)
                        ->required()
                        ->live(),
                    TextInput::make('discount')
                        ->visible(fn (Get $get)=>  !$get('special_order'))
                        ->disabled(fn (Get $get)=>  $get('item_id') == null)
                        ->numeric()
                        ->suffix('IQD')
                        ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3])
                        ->minValue(0)
                        ->maxValue(function (Get $get)  {
                            if($get('item_id') == null) {return;}
                            return Price::find($get('item_id'))->amount;
                        })
                        ->default(0)
                        ->live(),
                    Placeholder::make('created')
                        ->content(function (Get $get)  {
                            if($get('special_order'))
                            {
                                try {
                                    return $get('amount') * $get('quantity') . 'IQD';
                                } catch (\Throwable $th) {
                                    return '0IQD';
                                }
                            }
                            if($get('item_id') == null) {return '0IQD';}
                            try {
                                return ( Price::find($get('item_id'))->amount - $get('discount') ) * $get('quantity') . 'IQD';
                            } catch (\Throwable $th) {
                                return '0IQD';
                            }
                        })
                        ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3]),
                    TextInput::make('note')
                        ->columnSpan(12)
                        ->maxLength(64),
                ])
                ->addActionLabel('Add Order')
                ->columns(12)
            ])
            ->statePath('data');
    }

    public function create()
    {
        if (isset($this->data['orders']) ){
            foreach ($this->data['orders'] as $key => $order)
            {
                for ($i=0; $i < $order['quantity']; $i++)
                {
                    if($order['special_order'])
                    {
                        Order::create([
                            'invoice_id' => $this->invoice->id,
                            'title' => $order['title'],
                            'user_id' => Auth::id(),
                            'amount' => $order['amount'],
                            'total_amount' => $order['amount'],
                            'discount_fixed' => 0,
                            'note' => $order['note'],
                        ]);
                    }
                    else
                    {
                        $price = Price::find($order['item_id']);
                        $item = $price->item;

                        Order::create([
                            'invoice_id' => $this->invoice->id,
                            'title' => $item->title,
                            'item_id' => $item->id,
                            'price_id' => $price->id,
                            'user_id' => Auth::id(),
                            'amount' => $price->amount,
                            'discount_fixed' => $order['discount'],
                            'total_amount' => $price->amount -  $order['discount'],
                            'note' =>  $order['note'],
                        ]);
                    }
                }
            }

            // UPDATE THE AMOUNT OF THE INVOICE
            Invoice::find($this->invoice->id)->updateAmount();
        }

        return redirect('invoices/' . $this->invoice->id);
    }
    public function render()
    {
        return view('livewire.invoice.new-orders');
    }
}
