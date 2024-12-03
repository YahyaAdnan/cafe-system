<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceResource\Pages;
use App\Filament\Resources\PriceResource\RelationManagers;
use App\Models\Price;
use App\Models\Ingredient;
use App\Models\IngredientDetails;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriceResource extends Resource
{
    protected static ?string $model = Price::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static ?string $label = 'Ingredient Details';


    public static function canCreate(): bool
    {
       return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('ingredientDetails')
                    ->relationship()
                    ->schema([
                        Grid::make(['sm' => 1,'md' => 2,'lg' => 2, ])
                            ->schema([
                                Select::make('ingredient_id')
                                    ->label('Ingrident')
                                    ->options(Ingredient::pluck('title', 'id'))
                                    ->disabled(),
                                TextInput::make('amount')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        // ImageColumn::make('image')->circular(),
        // TextColumn::make('title')->label('Title (EN)')->sortable(),
        // TextColumn::make('title_ar')->label('Title (AR)')->sortable(),
        // TextColumn::make('title_ku')->label('Title (KU)')->sortable(),
        // TextColumn::make('items.title')
        return $table
            ->columns([
                TextColumn::make('item.title')
                    ->color(fn(Price $price) => $price->validateIngredient() ? 'primary' : 'danger')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([  
                Filter::make('filters')
                    ->label("")
                    ->form([
                        Select::make('validated')
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
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPrices::route('/'),
            // 'create' => Pages\CreatePrice::route('/create'),
            'edit' => Pages\EditPrice::route('/{record}/edit'),
        ];
    }
}
