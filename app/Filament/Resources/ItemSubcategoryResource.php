<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemSubcategoryResource\Pages;
use App\Filament\Resources\ItemSubcategoryResource\RelationManagers;
use App\Models\ItemSubcategory;
use App\Models\ItemCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ItemSubcategoryResource extends Resource
{
    protected static ?string $model = ItemSubcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Item Settings';

    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create item_subcategories');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->required()
                    ->avatar()
                    ->directory('ItemSubcategories')
                    ->storeFileNamesIn('ItemSubcategories'),
                Select::make('item_category_id')->options(ItemCategory::pluck('title','id'))
                    ->label('Item Category')->searchable()->required(),
                TextInput::make('title')->required()->minLength(3)->label('Title (EN)')->columns(1),
                TextInput::make('title_ar')->required()->minLength(3)->label('Title (AR)'),
                TextInput::make('title_ku')->required()->minLength(3)->label('Title (KU)'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('itemCategory.title')->label('Category')->sortable(),
                TextColumn::make('title')->label('Title (EN)')->sortable()->searchable(),
                TextColumn::make('title_ar')->label('Title (AR)')->sortable()->searchable(),
                TextColumn::make('title_ku')->label('Title (KU)')->sortable()->searchable(),
            ])
            ->filters([
                SelectFilter::make('Item Category')->options(ItemCategory::pluck('title','id'))->attribute('item_category_id')
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
            'index' => Pages\ListItemSubcategories::route('/'),
            'create' => Pages\CreateItemSubcategory::route('/create'),
            'edit' => Pages\EditItemSubcategory::route('/{record}/edit'),
        ];
    }
}
