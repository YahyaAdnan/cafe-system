<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryRecordResource\Pages;
use App\Filament\Resources\InventoryRecordResource\RelationManagers;
use App\Models\InventoryRecord;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryRecordResource extends Resource
{
    protected static ?string $model = InventoryRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                Select::make('supplier_id')
                    ->label('supplier')
                    ->columnSpan(6)
                    ->searchable()
                    ->relationship(name: 'supplier', titleAttribute: 'title')
                    ->createOptionForm([
                        TextInput::make('title')->minLength(3)->required(),
                    ])->disabled(fn(Get $get) => $get("type") != "Increase"),
                TextInput::make('quantity')->columnSpan(6)
                    ->suffix(fn(Get $get) => $get("inventory_id") ? Inventory::find($get("inventory_id"))->inventoryUnit->title : "")
                    ->numeric()->minValue(0)->required(),
                // END: RECORD DETAILS
                // START: CHECK IF THEY PAID.
                Toggle::make('paid')->live(),
                Fieldset::make('expense')
                    ->relationship('expense')
                    ->schema([
                        TextInput::make('title')->hidden(1)
                            ->default(fn(Get $get) => $get("inventory_id") ? Inventory::find($get("inventory_id"))->inventoryUnit->title : ""),
                        DatePicker::make('date')->default(today()),
                        TextInput::make('amount')->numeric()->minValue(0)->required(),
                        TextInput::make('expense_category_id')->hidden(1)->default(1),
                    ])->disabled(fn(Get $get) => ! $get("paid")),
                // END: CHECK IF THEY PAID.
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'edit' => Pages\EditInventoryRecord::route('/{record}/edit'),
        ];
    }
}
