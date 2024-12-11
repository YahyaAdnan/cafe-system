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
use App\Services\DiscountService;
use Filament\Forms\Get;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Radio;
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
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 4])
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
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 4])
                ->minValue(1)
                ->maxValue(100000000)
                ->prefix("IQD")
                ->required()
                ->live(),
            // *** ENDS: QUANTITY ***

            // *** STARTS: DISCOUNT ***      
            Placeholder::make('total_amount')
                ->content(fn (Get $get)=> ($get('quantity') * $get('amount')) ?? 0)
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 4]),
                
            TextInput::make('note')
                ->columnSpan(12)
                ->maxLength(64),
        ];
    }

    public static function specialSelect(Item $item)
    {
        return [

            // *** STARTS: PRICE ***
            Radio::make('price_id')
                ->label('Price')
                ->options(fn(Item $item) => $item->prices->pluck('title', 'id'))
                ->default($item->prices->first()->id)
                ->required()
                ->columnSpan(12),
            // *** ENDS: PRICE ***

            // *** STARTS: QUANTITY ***
            // *** DEFAULT: 1 ***
            // *** MIN: 1 ***
            // *** MAX: 99 ***
            TextInput::make('quantity')
                ->numeric()
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 4])
                ->default(1)
                ->minValue(1)
                ->maxValue(99)
                ->required()
                ->live(),
            // *** ENDS: QUANTITY ***

            // *** STARTS: AMOUNT ***
            // *** MIN: 1 ***
            // *** MAX: 100000000 ***
            TextInput::make('discount')
                ->disabled(fn (Get $get)=>  $get('item_id'))
                ->numeric()
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 4])
                ->minValue(1)
                ->maxValue(DiscountService::maximumItemDiscount(fn (Get $get)=>  Price::find($get('price_id'))->amount))
                ->prefix("IQD")
                ->live(),
            // *** ENDS: QUANTITY ***

            // *** STARTS: DISCOUNT ***      
            Placeholder::make('total_amount')
                ->content(fn (Get $get) => max(
                        ((int) $get('quantity') * ((Price::find($get('price_id'))->amount ?? 0) - ((float) $get('discount') ?? 0))), 
                        0
                    ))
                ->columnSpan(['sm' => 12, 'md' => 4, 'xl' => 4]),
                
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

    public static function table(Table $table, $filter)
    {
        return $table
            ->query(Item::where('item_type_id', $filter['item_type_id'])->where('item_category_id', $filter['item_category_id']))
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
            ->contentGrid(['sm' => 2, 'md' => 2, 'xl' => 4]);
    }
    
}