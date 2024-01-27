<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IngredientResource\Pages;
use App\Filament\Resources\IngredientResource\RelationManagers;
use App\Models\Ingredient;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Filters\SelectFilter;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class IngredientResource extends Resource
{
    protected static ?string $model = Ingredient::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create ingredients');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->label('Title (EN)')->minLength(3),
                TextInput::make('title_ar')->required()->label('Title (EN)')->minLength(3),
                TextInput::make('title_ku')->required()->label('Title (EN)')->minLength(3),
                Toggle::make('is_available')->onColor('success')->offColor('danger'),
                // START: REPEATER for Ingredient
                Repeater::make('itemIngredient')
                    ->relationship()
                    ->schema([
                        Select::make('item_id')->options(Item::pluck('title', 'id'))
                            ->searchable()->label('Item')->columnSpan(4)->required(),                      
                        Select::make('main')->options([
                            '0' => 'Not Main',
                            '1' => 'Main',
                        ])->native(false)->required()->columnSpan(4),
                        TextInput::make('note')->columnSpan(4),
                    ])->columns(12)
                    ->reorderableWithButtons()
                    ->columnSpanFull(),
                // END: REPEATER for Ingredient
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title (EN)')->sortable(),
                TextColumn::make('title_ar')->label('Title (AR)')->sortable(),
                TextColumn::make('title_ku')->label('Title (KU)')->sortable(),
                TextColumn::make('items_count')->counts('itemIngredient')

            ])
            ->filters([
                
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
            'index' => Pages\ListIngredients::route('/'),
            'create' => Pages\CreateIngredient::route('/create'),
            'edit' => Pages\EditIngredient::route('/{record}/edit'),
        ];
    }
}
