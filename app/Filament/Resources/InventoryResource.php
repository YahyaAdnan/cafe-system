<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Models\Inventory;
use App\Models\InventoryUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Get;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([         
                // TODO: ADD UNIQUE TO UNITS
                TextInput::make('title')->columnSpan(6)->required()->minLength(3)->maxLength(32)->unique(
                    modifyRuleUsing: function (Unique $rule, Get $get) {
                        return $rule->where('title', $get('title'));
                    }, ignoreRecord: true
                ),
                Select::make('inventory_unit_id')->columnSpan(6)->required()->options(
                    InventoryUnit::pluck('title', 'id')
                )->searchable(),
                TextInput::make('note')->columnSpan(12)->maxLength(250),
                ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('quantity')->suffix(
                    fn (Inventory $inventory) => $inventory->inventoryUnit->title
                ),
                TextColumn::make('user.name')->label('Added By')->toggleable()->sortable(),
                TextColumn::make('note')->toggleable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('inventory_unit_id')->native(false)
                    ->options(InventoryUnit::pluck('title', 'id')),
                Filter::make('quantity')
                    ->form([
                        TextInput::make('minimum_quantity')->numeric()->minValue(0),
                        TextInput::make('maximum_quantity')->numeric()->minValue(0),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['minimum_quantity'],
                                fn (Builder $query, $quantity): Builder => $query->where('quantity', '>=', $quantity),
                            )
                            ->when(
                                $data['maximum_quantity'],
                                fn (Builder $query, $quantity): Builder => $query->where('quantity', '<=', $quantity),
                            );
                    })
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
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
