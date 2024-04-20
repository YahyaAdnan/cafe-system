<?php
namespace App\Services\Filament;

use App\Models\Invoice;
use App\Models\DailySale;
use App\Models\Price;
use App\Models\Order;
use Filament\Forms\Get;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use App\Services\EstimatePrice;

class OrdersForm
{
    public static function form()
    {
        return [
            // *** STARTS: SPECIAL ORDERS ***
            // TO CHECK IF THE ORDER IS SPECIAL
            // SPECIAL ORDERS DOESN'T REQUIRES ITEM ID
            // SPECIAL ORDERS NEED TO WRITE TITLE.
            Toggle::make('special_order')
                ->inline()
                ->columnSpan(12)
                ->live(),
            // *** ENDS: SPECIAL ORDERS ***
        
            // *** STARTS: ITEM ***
            // WE GET THE PRICE ID THEN CONVERT IT TO ITEM ID 
            Select::make('item_id')
                ->visible(fn (Get $get)=>  !$get('special_order'))
                ->searchable()
                ->columnSpan(['sm' => 12, 'md' => 6, 'xl' => 3])
                ->options(Price::activePrices())
                ->required()
                ->live(),
            // *** ENDS: ITEM ***

            // *** STARTS: TITLE ***
            TextInput::make('title')
                ->visible(fn (Get $get)=>  $get('special_order'))
                ->columnSpan(['sm' => 12, 'md' => 6, 'xl' => 3])
                ->minLength(1)
                ->maxLength(32)
                ->required(),
            // *** ENDS: TITLE ***

            // *** STARTS: QUANTITY ***
            // *** DEFAULT: 1 ***
            // *** MIN: 1 ***
            // *** MAX: 99 ***
            TextInput::make('quantity')
                ->numeric()
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3])
                ->default(1)
                ->minValue(1)
                ->maxValue(99)
                ->required()
                ->live(),
            // *** ENDS: QUANTITY ***

            // *** STARTS: AMOUNT ***
            // *** MIN: 1 ***
            // *** MAX: 100000000 ***
            TextInput::make('amount')
                ->visible(fn (Get $get)=>  $get('special_order'))
                ->numeric()
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3])
                ->minValue(1)
                ->maxValue(100000000)
                ->required()
                ->live(),
            // *** ENDS: QUANTITY ***

            // *** STARTS: DISCOUNT ***
            // *** MIN: 0 ***
            // *** MAX: min(Maximum Discount, Price) ***
            TextInput::make('discount')
                ->visible(fn (Get $get)=>  !$get('special_order'))
                ->disabled(fn (Get $get)=>  $get('item_id') == null)
                ->numeric()
                ->suffix('IQD')
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3])
                ->required()
                ->minValue(0)
                ->maxValue(function (Get $get)  {
                    if($get('item_id') == null) {return;}
                    return Price::find($get('item_id'))->amount;
                })
                ->default(0)
                ->live(),
            // *** ENDS: MAX ***
            
            Placeholder::make('total_amount')
                ->content(function (Get $get)  {
                    return "IQD " . EstimatePrice::run([
                        'amount' => $get('special_order') ? $get('amount') : null ,
                        'discount' => $get('special_order') ? null : $get('discount'),
                        'price_id' => $get('special_order') ? null : $get('item_id'),
                        'extras' => $get('special_order') ? null : $get('extras'),    
                        'quantity' => $get('quantity')                 
                    ]);
                })
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 3]),
            Select::make('extras')
                ->columnSpan(12)
                ->multiple()
                ->visible(fn (Get $get)=>  !$get('special_order'))
                ->options(function (Get $get) { 
                    if($get('item_id'))
                    {
                        return Price::find($get('item_id'))->item->extras->pluck('title', 'id');
                    }
                })
                ->live(),
            TextInput::make('note')
                ->columnSpan(12)
                ->maxLength(64),
        ];
    }


    public static function store($data)
    {
        if (isset($data['orders'])) {
            foreach ($data['orders'] as $key => $order) {
                // Loop through each order
                for ($i = 0; $i < $order['quantity']; $i++) {
                    // Create orders based on the quantity specified
    
                    // Determine price and item based on whether it's a special order or not
                    $price = $order['special_order']
                        ? null
                        : Price::find($order['item_id']);
                    $item = $order['special_order']
                        ? null
                        : $price->item;
    
                    // Set attributes for the order
                    $attributes = array();
    
                    // Common attributes
                    $attributes['invoice_id'] = $data['invoice']->id;
                    $attributes['user_id'] = Auth::id();
                    $attributes['note'] = $order['note'];
    
                    // Conditionally set attributes based on whether it's a special order or not
                    if ($order['special_order']) {
                        $attributes['title'] = $order['title'];
                        $attributes['item_id'] = null;
                        $attributes['price_id'] = null;
                        $attributes['amount'] = $order['amount'];
                        $attributes['discount_fixed'] = 0;
                    } else {
                        $attributes['title'] = $item->title;
                        $attributes['item_id'] = $item->id;
                        $attributes['price_id'] = $price->id;
                        $attributes['amount'] = $price->amount;
                        $attributes['discount_fixed'] = $order['discount_fixed'];
                    }
    
                    $attributes['total_amount'] = 0; // Will be updated boot function in the order class.
    
                    // Create the order
                    $new_order = Order::create($attributes);
                }
            }
    
            // Update the amount of the invoice
            Invoice::find($data['invoice']->id)->updateAmount();
        }
    
        // Redirect to the invoice page
        return redirect('invoices/' . $data['invoice']->id);
    }

}