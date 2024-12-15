<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemDetailsResource\Pages;
use App\Filament\Resources\ItemDetailsResource\RelationManagers;
use App\Models\Price;
use App\Models\Item;
use App\Models\Ingredient;
use App\Models\IngredientDetails;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemDetailsResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $modelLabel = 'Recipes';
    protected static ?string $navigationGroup = 'Item Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Repeater::make('prices')
                    ->relationship()
                    ->schema([
                        Components\Repeater::make('ingredientDetails')
                        ->relationship()
                        ->schema([
                            Components\Grid::make(['sm' => 1,'md' => 2,'lg' => 2, ])
                                ->schema([
                                    Components\Select::make('ingredient_id')
                                        ->label('Ingrident')
                                        ->options(Ingredient::pluck('title', 'id'))
                                        ->disabled(),
                                    Components\TextInput::make('amount')
                                        ->required()
                                        ->minValue(0)
                                        ->suffix(fn(IngredientDetails $ingDet) => 
                                            $ingDet->ingredient->inventories->first()->inventoryUnit->title ?? 'KG'
                                        )
                                ])
                        ])
                        ->columnSpanFull()
                        ->addable(false)
                        ->deletable(false),
                    ])
                    ->itemLabel(fn (array $state) => $state['title'])
                    ->columnSpanFull()
                    ->addable(false)
                    ->deletable(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->badge()
                    ->color(fn(Item $item) => $item->validateIngredient() ? 'success' : 'danger')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Filter::make('filters')
                    ->label("")
                    ->form([
                        Components\Select::make('validated')
                            ->options([
                                "0" => "All",
                                "1" => "Validated",
                                "2" => "Unvalidated",
                            ])
                            ->native(false)
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['validated'],
                                function (Builder $query, $data)
                                {
                                    if($data == "1")
                                    {
                                        return $query->whereNotIn('id', IngredientDetails::where('amount', 0)->pluck('price_id'));
                                    }

                                    if($data == "2")
                                    {
                                        return $query->whereIn('id', IngredientDetails::where('amount', 0)->pluck('price_id'));
                                    }
                                },
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListItemDetails::route('/'),
            'create' => Pages\CreateItemDetails::route('/create'),
            'edit' => Pages\EditItemDetails::route('/{record}/edit'),
        ];
    }
}
