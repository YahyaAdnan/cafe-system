<?php
namespace App\Services\Filament;

use App\Models\Invoice;
use App\Models\DailySale;
use App\Models\Price;
use App\Models\Order;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\ItemCategory;
use App\Models\ItemSubcategory;
use Filament\Forms\Get;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Grid;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Alignment;
use App\Services\EstimatePrice;
use Illuminate\Database\Eloquent\Builder;

class OrdersForm
{
    public static function form()
    {
        return [
            // *** STARTS: TITLE ***
            TextInput::make('title')
                ->disabled(fn (Get $get)=>  $get('item_id'))
                ->columnSpan('12')
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
                ->columnSpan(['sm' => 12, 'md' => 3, 'xl' => 3])
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
                ->disabled(fn (Get $get)=>  $get('item_id'))
                ->numeric()
                ->columnSpan(['sm' => 12, 'md' => 3, 'xl' => 3])
                ->minValue(1)
                ->maxValue(100000000)
                ->required()
                ->live(),
            // *** ENDS: QUANTITY ***

            // *** STARTS: DISCOUNT ***
            // *** MIN: 0 ***
            // *** MAX: min(Maximum Discount, Price) ***
            TextInput::make('discount')
                ->disabled(fn (Get $get)=>  $get('item_id') == null)
                ->numeric()
                ->columnSpan(['sm' => 12, 'md' => 3, 'xl' => 3])
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
                        'amount' => $get('item_id') ? $get('amount') : null ,
                        'discount' => $get('item_id') ? null : $get('discount'),
                        'price_id' => $get('item_id') ? null : $get('item_id'),
                        'extras' => $get('item_id') ? null : $get('extras'),    
                        'quantity' => $get('quantity')                 
                    ]);
                })
                ->columnSpan(['sm' => 12, 'md' => 3, 'xl' => 3]),

            Select::make('extras')
                ->columnSpan(12)
                ->multiple()
                ->visible(fn (Get $get)=>  $get('item_id'))
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


    // Parameters: orders, invoice
    // Orders: Array, Array of order inputs.
    // Invoice: Invoice Model.
    public static function store($data)
    {
        if (isset($data['orders'])) {
            foreach ($data['orders'] as $key => $order) {
                // Loop through each order
                for ($i = 0; $i < $order['quantity']; $i++) {
                    // Create orders based on the quantity specified
    
                    // Determine price and item based on whether it's a special order or not
                    $price = $order['item_id']
                        ? Price::find($order['item_id'])
                        : null;
                    $item = $order['item_id']
                        ? $price->item
                        : null;

                    // Set attributes for the order
                    $attributes = array();
    
                    // Common attributes
                    $attributes['invoice_id'] = $data['invoice']->id;
                    $attributes['user_id'] = Auth::id();
                    $attributes['note'] = $order['note'];
    
                    // Conditionally set attributes based on whether it's a special order or not
                    if ($order['item_id']) 
                    {
                        $attributes['title'] = $item->title;
                        $attributes['item_id'] = $item->id;
                        $attributes['price_id'] = $price->id;
                        $attributes['amount'] = $price->amount;
                        $attributes['discount_fixed'] = $order['discount'];
                    } else {
                        $attributes['title'] = $order['title'];
                        $attributes['item_id'] = null;
                        $attributes['price_id'] = null;
                        $attributes['amount'] = $order['amount'];
                        $attributes['discount_fixed'] = 0;
                    }
    
                    $attributes['total_amount'] = EstimatePrice::run([
                        'amount' => $attributes['amount'],
                        'discount' => $attributes['discount_fixed'],
                        'extras' => $order['extras']    
                    ]);
    
                    // Create the order
                    $new_order = Order::create($attributes);

                    $new_order->extras()->attach($order['extras']);
                }
            }
    
        }
    }

    public static function table(Table $table)
    {
        return $table
            ->query(Item::query())
            ->columns([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        TextColumn::make('title')
                            ->alignment(Alignment::Center)
                            ->weight(FontWeight::SemiBold)
                            ->searchable()
                    ])
            ])
            ->filters([
                Filter::make('category_filter')
                ->form([
                    Select::make('item_type_id')
                        ->label('Item Type')
                        ->options(ItemType::pluck('title', 'id'))
                        ->searchable()
                        ->live(),
                    Select::make('item_category_id')
                        ->label('Item Category')
                        ->options(function ($get) {
                            if ($item_type_id = $get('item_type_id')) {
                                return ItemCategory::where('item_type_id', $item_type_id)->pluck('title', 'id');
                            }
                            return ItemCategory::pluck('title', 'id');
                        })
                        ->searchable()
                        ->live(),
                    Select::make('item_subcategory_id')
                        ->label('Item Subcategory')
                        ->options(function ($get) {
                            if ($category_id = $get('item_category_id')) {
                                return ItemSubcategory::where('item_category_id', $category_id)->pluck('title', 'id');
                            }
                            return ItemSubcategory::pluck('title', 'id');
                        })
                        ->searchable()
                        ->live(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['item_type_id'],
                            fn (Builder $query, $item_type_id): Builder => $query->where('item_type_id', $item_type_id)
                        )
                        ->when(
                            $data['item_category_id'],
                            fn (Builder $query, $category_id): Builder => $query->where('item_category_id', $category_id)
                        )
                        ->when(
                            $data['item_subcategory_id'],
                            fn (Builder $query, $subcategory_id): Builder => $query->where('item_subcategory_id', $subcategory_id)
                        );
                })
            ])
            ->contentGrid(['sm' => 2, 'md' => 2, 'xl' => 4]);
    }
}