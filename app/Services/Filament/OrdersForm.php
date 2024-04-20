<?php
namespace App\Services\Filament;

use App\Models\Invoice;
use App\Models\DailySale;
use App\Models\Price;
use Filament\Forms\Get;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;

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
            
            Select::make('extras')
                ->options(function (Get $get) { 
                    if($get('item_id'))
                    {
                        return Price::find($get('item_id'))->item->extras->pluck('title', 'id');
                    }
                })
                ->visible(fn (Get $get)=>  !$get('special_order'))
                ->multiple()
                ->columnSpan(12),
            TextInput::make('note')
                ->columnSpan(12)
                ->maxLength(64),
        ];
    }

    // public static function form()
    // {

    // }
}