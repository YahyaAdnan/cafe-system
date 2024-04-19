<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
class RoomResource extends Resource
{
    protected static ?string $model = Room::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Configs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('title')
                            ->label('Title')
                            ->required(),
                        Select::make('cashier')
                            ->label('Has Cashier Station')
                            ->options([
                                '1' => 'Yes',
                                '0' => 'No',
                            ])
                            ->default('0'),
                        Select::make('monitor')
                            ->label('Has Monitor')
                            ->options([
                                '1' => 'Yes',
                                '0' => 'No',
                            ])
                            ->default('0'),
                        Select::make('printing')
                            ->label('Has Printing')
                            ->options([
                                '1' => 'Yes',
                                '0' => 'No',
                            ])
                            ->default('0'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable(),
                BooleanColumn::make('cashier')
                    ->label('Cashier'),
                BooleanColumn::make('monitor')
                    ->label('Monitor'),
                BooleanColumn::make('printing')
                    ->label('Printing'),
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
