<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomConfigResource\Pages;
use App\Filament\Resources\RoomConfigResource\RelationManagers;
use Hoa\Iterator\Repeater;
use App\Models\{Item, RoomConfig, ItemCategory, ItemType, Room};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components;
class RoomConfigResource extends Resource
{
    protected static ?string $model = RoomConfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Select::make('roomable_type')
                            ->options([
                                "App\Models\ItemCategory" => "Category",
                                "App\Models\ItemType" => "Type",
                                "App\Models\Item" => "Item",

                            ])
                            ->searchable(true)
                            ->live()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $set) {
                                $set('roomable_id', null);
                                ray('roomable_type updated', $state); // Debugging with Ray
                            })
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                        Select::make('roomable_id')
                            ->required()
                            ->searchable(true)
                            ->live()
                            ->options(function (callable $get) {
                                $type = $get('roomable_type');
                                ray('Fetching options for: ', $type); // Debugging with Ray
                                if ($type == 'App\Models\ItemCategory') {
                                    return ItemCategory::query()->pluck('title', 'id');
                                } elseif ($type == 'App\Models\ItemType') {
                                    return ItemType::query()->pluck('title', 'id');
                                }elseif ($type == 'App\Models\Item'){
                                    return Item::query()->pluck('title', 'id');
                                }
                                return [];
                            })
                            ->visible(fn (callable $get) => $get('roomable_type') !== null)
                            ->columnSpan([
                                'sm' => 2,
                            ]),
                        Select::make('room_id')
                            ->label('Room')
                            ->searchable(true)
                            ->required()
                            ->live()
                            ->options(Room::all()->pluck('title', 'id'))
                            ->visible(fn (callable $get) => $get('roomable_type') !== null)
                            ->columnSpan([
                                'sm' => 2,
                            ])
                            ->afterStateUpdated(fn ($state) => ray('room_id updated', $state)) // Debugging with Ray



            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('roomable_type')
                ->label('Type Of Room'),
                Tables\Columns\TextColumn::make('room_id'),
                Tables\Columns\TextColumn::make('roomable_id')
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
            'index' => Pages\ListRoomConfigs::route('/'),
            'create' => Pages\CreateRoomConfig::route('/create'),
            'edit' => Pages\EditRoomConfig::route('/{record}/edit'),
        ];
    }
}
