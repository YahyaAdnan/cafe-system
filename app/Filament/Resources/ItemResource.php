<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\ItemCategory;
use App\Models\ItemSubcategory;
use App\Models\Ingredient;
use App\Models\Extra;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create items');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // START: IMAGE
                FileUpload::make('image')
                    ->columnSpan(12)
                    ->required()
                    ->directory('items')
                    ->storeFileNamesIn('items'),
                // END: IMAGE
                // START: TITLE IN (AR, EN and KU)
                TextInput::make('title')->label('Title (EN)')->columnSpan(4)->required()->minLength(3)->maxLength(32),
                TextInput::make('title_ar')->label('Title (AR)')->columnSpan(4)->required()->minLength(3)->maxLength(32),
                TextInput::make('title_ku')->label('Title (KU)')->columnSpan(4)->required()->minLength(3)->maxLength(32),
                // END: TITLE IN (AR, EN and KU)
                // START: SELECT TYPE, CATEGORY and Subcategory
                Select::make('item_type_id')->options(ItemType::pluck('title', 'id'))
                    ->searchable()->label('Item Type')->columnSpan(4)->required()->live(),
                Select::make('item_category_id')->options(
                        fn (Get $get): Collection => ItemCategory::query()
                            ->where('item_type_id', $get('item_type_id'))
                            ->pluck('title', 'id')
                    )->searchable()->label('Item Category')->columnSpan(4)->required()->live(),
                Select::make('item_subcategory_id')->options(
                        fn (Get $get): Collection => ItemSubcategory::query()
                            ->where('item_category_id', $get('item_category_id'))
                            ->pluck('title', 'id')
                    )->searchable()->label('Item Category')->columnSpan(4)->live(),
                // END: SELECT TYPE, CATEGORY and Subcategory
                // START: Info availablity
                Toggle::make('is_available')->onColor('success')->offColor('gray')->columnSpan(4),
                Toggle::make('show')->onColor('success')->offColor('gray')->columnSpan(4),
                Toggle::make('show_ingredients')->onColor('success')->offColor('gray')->columnSpan(4),
                // END: Info availablity
                // START: REPEATER for Ingredient
                Repeater::make('itemIngredients')
                    ->relationship()
                    ->schema([
                        Select::make('ingredient_id')->options(Ingredient::pluck('title', 'id'))
                            ->searchable()->label('Ingredient')->columnSpan(4)->required()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems(),                      
                        Select::make('main')->options([
                            '0' => 'Not Main',
                            '1' => 'Main',
                        ])->native(false)->required()->columnSpan(4),
                        TextInput::make('note')->columnSpan(4)->maxLength(250),
                    ])->columns(12)
                    ->reorderableWithButtons()
                    ->columnSpanFull(),
                // END: REPEATER for Ingredient
                // START: REPEATER for Prices
                Repeater::make('prices')
                    ->relationship()
                    ->schema([
                        TextInput::make('title')->columnSpan(6)->required()->minLength(3)->maxLength(32)->distinct(),
                        TextInput::make('amount')->suffix('IQD')->columnSpan(6)->required()->numeric(),
                    ])
                    ->minItems(1)
                    ->columns(12)
                    ->reorderableWithButtons()
                    ->columnSpanFull(),
                // END: REPEATER for Prices
                // START: Select Extra
                Select::make('extras')
                    ->columnSpan(12)
                    ->multiple()
                    ->relationship(name: 'extras', titleAttribute: 'title')
                    ->createOptionForm([
                        TextInput::make('title')
                            ->required()->minLength(3)->maxLength(32),
                        TextInput::make('amount')
                            ->suffix('IQD')->numeric()->minValue(0)
                            ->required(),
                    ])->searchable()
                    ->preload()
                // END: Select Extra
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('title')->label('Title')->sortable()->searchable(),
                TextColumn::make('itemType.title')->label('Type')->sortable(),
                TextColumn::make('itemCategory.title')->label('Category')->sortable(),
                TextColumn::make('itemSubcategory.title')->label('Subcategory')->sortable(),
                IconColumn::make('is_available')->boolean()
            ])
            ->filters([
                SelectFilter::make('item_type_id')->label('Item Type')
                    ->options(ItemType::pluck('title', 'id'))->searchable(),
                SelectFilter::make('item_category_id')->label('Item Category')
                    ->options(ItemCategory::pluck('title', 'id'))->searchable(),
                SelectFilter::make('item_subcategory_id')->label('Item Subcategory')
                    ->options(ItemSubcategory::pluck('title', 'id'))->searchable(),
                SelectFilter::make('is_available')->options([
                    '0' => 'Unavailable',
                    '1' => 'Available',
                ])->native(false),
                SelectFilter::make('show')->label('Showing')->options([
                    '0' => 'Hidden',
                    '1' => 'Showing',
                ])->native(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn(Item $item) => $item->isDeletable()
            )
            ->recordUrl(null);
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
