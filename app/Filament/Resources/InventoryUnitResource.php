<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryUnitResource\Pages;
use App\Filament\Resources\InventoryUnitResource\RelationManagers;
use App\Models\InventoryUnit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;
use Filament\Forms\Get;

class InventoryUnitResource extends Resource
{
    protected static ?string $model = InventoryUnit::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?string $navigationGroup = 'Inventory';
    protected static ?int $navigationSort = 1;

    // TODO: MAKE RELATIONS

    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create inventory_units');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->minLength(1)->maxLength(32)->unique(
                    modifyRuleUsing: function (Unique $rule, Get $get) {
                        return $rule->where('title', $get('title'));
                    }, ignoreRecord: true
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable(),
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
            'index' => Pages\ListInventoryUnits::route('/'),
            // 'create' => Pages\CreateInventoryUnit::route('/create'),
            // 'edit' => Pages\EditInventoryUnit::route('/{record}/edit'),
        ];
    }
}
