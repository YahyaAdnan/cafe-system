<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->columnSpan(['sm' => 12, 'md' => 4])
                    ->label('Title')
                    ->required()
                    ->minLength(3)
                    ->maxLength(64),
                TextInput::make('title_ar')
                    ->columnSpan(['sm' => 12, 'md' => 4])
                    ->label('Title (AR')
                    ->required()
                    ->minLength(3)
                    ->maxLength(64),
                TextInput::make('title_ku')
                    ->columnSpan(['sm' => 12, 'md' => 4])
                    ->label('Title (KR)')
                    ->required()
                    ->minLength(3)
                    ->maxLength(64),
                DatePicker::make('date')
                    ->native(0)
                    ->columnSpan(['sm' => 12, 'md' => 4])
                    ->default(today())
                    ->required(),
                Repeater::make('offerEntities')
                    ->schema([
                        Select::make('items')
                            ->options(Item::pluck('title', 'id'))
                            ->columnSpan(['sm' => 12, 'md' => 6])
                            ->multiple()
                            ->required(),
                        TextInput::make('price')
                            ->label('Amount')
                            ->columnSpan(['sm' => 12, 'md' => 6])
                            ->suffix('IQD')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(100000000),
                        Toggle::make('show')
                            ->default(1)
                            ->columnSpan(3),
                        Toggle::make('active')
                            ->default(1)
                            ->columnSpan(3),
                    ])->columns(12)
                    ->columnSpan(12)
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('title_ar')->toggleable(),
                TextColumn::make('title_ku')->toggleable(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
