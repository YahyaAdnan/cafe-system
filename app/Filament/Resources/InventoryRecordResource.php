<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryRecordResource\Pages;
use App\Filament\Resources\InventoryRecordResource\RelationManagers;
use App\Models\InventoryRecord;
use App\Models\PaymentMethod;
use App\Models\Supplier;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class InventoryRecordResource extends Resource
{
    protected static ?string $model = InventoryRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Inventory';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create inventory_records');
    }

    // TODO: MAKE RELATIONS

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // START: TYPE OF RECORD
                Select::make('type')->columnSpan(6)->required()
                    ->native(false)->options([
                        'Increase' => 'Increase',
                        'Decrease' => 'Decrease',
                    ])->live(),
                // END: TYPE OF RECORD
                // START: RECORD DETAILS
                Select::make('inventory_id')->label("inventory")->columnSpan(6)->required()
                    ->searchable()->options(
                        Inventory::pluck('title', 'id')
                    )->live(),
                TextInput::make('supplier_id_to_hide')->label('supplier')
                    ->columnSpan(6)
                    ->disabled(fn(Get $get) => $get("type") != "Increase")
                    ->hidden(fn(Get $get) => $get("type") == "Increase"),
                Select::make('supplier_id')
                    ->label('supplier')
                    ->options(supplier::pluck('title', 'id'))
                    ->columnSpan(6)
                    ->relationship(name: 'supplier', titleAttribute: 'title')
                    ->createOptionForm([
                        TextInput::make('title')->minLength(3)->required(),
                    ])->searchable()->preload()
                    ->hidden(fn(Get $get) => $get("type") != "Increase"),
                TextInput::make('quantity')->columnSpan(6)
                    ->suffix(fn(Get $get) => $get("inventory_id") ? Inventory::find($get("inventory_id"))->inventoryUnit->title : "")
                    ->numeric()->minValue(0)->required(),
                // END: RECORD DETAILS
                // START: CHECK IF THEY PAID.
                Toggle::make('paid')->disabled(fn(Get $get) => $get("type") != "Increase")->live(),
                Fieldset::make('expense')
                    ->relationship('expense')
                    ->schema([
                        Hidden::make('title')
                            ->default(fn(Get $get) => "-"),
                        DatePicker::make('date')->required()->default(today()),
                        TextInput::make('amount')->suffix('IQD')->numeric()->minValue(0)->required(),
                        Hidden::make('expense_category_id')->default(1),
                        Select::make('payment_method_id')->required()
                            ->options(PaymentMethod::pluck('title', 'id'))
                            ->searchable()
                    ])->hidden(fn(Get $get) => !$get("paid")),
                // END: CHECK IF THEY PAID.
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory.title')->label('Title')->sortable()->searchable(),
                TextColumn::make('supplier.title')->label('supplier')->sortable()->toggleable(),
                TextColumn::make('quantity')->badge()->label('quantity')
                    ->suffix(fn(InventoryRecord $record) => ' ' . $record->inventory->inventoryUnit->title)
                    ->color(fn(InventoryRecord $record) => $record->type == "Increase" ?  "success" : "danger")
                    ->sortable(),
                TextColumn::make('created_at')->label('Date')->datetime(),
            ])
            ->filters([
                Filter::make('filter')
                ->form([
                    Select::make('inventories')
                        ->multiple()
                        ->options(Inventory::pluck('title', 'id')),
                    // START: TYPE OF RECORD
                    Select::make('type')->required()
                    ->native(false)->options([
                        'Increase' => 'Increase',
                        'Decrease' => 'Decrease',
                    ])->live(),
                    // END: TYPE OF RECORD
                    Select::make('suppliers')
                        ->multiple()
                        ->label('suppliers')
                        ->options(Supplier::pluck('title', 'id'))
                        ->visible(fn(Get $get):bool => $get('type') == "Increase"),

                    TextInput::make('minimum_quantity')->numeric()->minValue(0),
                    TextInput::make('maximum_quantity')->numeric()->minValue(0),

                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            function (Builder $query, $date)
                            {
                                return $query->whereDate('created_at', '>=', $date);
                            }
                        )
                        ->when(
                            $data['created_until'],
                            function (Builder $query, $date) 
                            {
                                return $query->whereDate('created_until', '<=', $date);
                            }
                        )
                        ->when(
                            $data['inventories'],
                            function (Builder $query, $inventories)
                            {
                                return $query->whereIn('inventory_id', $inventories);
                            }
                        )
                        ->when(
                            $data['type'],
                            function (Builder $query, $type) 
                            { 
                                return $query->where('type', $type);
                            }
                        );
                })   
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventoryRecords::route('/'),
            'create' => Pages\CreateInventoryRecord::route('/create'),
            // 'edit' => Pages\EditInventoryRecord::route('/{record}/edit'),
        ];
    }
}
