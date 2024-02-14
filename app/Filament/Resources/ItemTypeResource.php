<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemTypeResource\Pages;
use App\Filament\Resources\ItemTypeResource\RelationManagers;
use App\Models\ItemType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ItemTypeResource extends Resource
{
    protected static ?string $model = ItemType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Item Settings';


    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create item_types');
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            FileUpload::make('image')
                ->required()
                ->avatar()
                ->directory('ItemTypes')
                ->storeFileNamesIn('ItemTypes'),
            TextInput::make('title')->required()->minLength(3)->maxLength(32)->label('Title (EN)')->columns(1),
            TextInput::make('title_ar')->required()->minLength(3)->maxLength(32)->label('Title (AR)'),
            TextInput::make('title_ku')->required()->minLength(3)->maxLength(32)->label('Title (KU)'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->circular(),
                TextColumn::make('title')->label('Title (EN)')->sortable(),
                TextColumn::make('title_ar')->label('Title (AR)')->sortable(),
                TextColumn::make('title_ku')->label('Title (KU)')->sortable(),
                TextColumn::make('items.title')
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
            'index' => Pages\ListItemTypes::route('/'),
            'create' => Pages\CreateItemType::route('/create'),
            'edit' => Pages\EditItemType::route('/{record}/edit'),
        ];
    }
}
