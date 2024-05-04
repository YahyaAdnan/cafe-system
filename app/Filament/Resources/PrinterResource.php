<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrinterResource\Pages;
use App\Filament\Resources\PrinterResource\RelationManagers;
use App\Models\Printer;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
class PrinterResource extends Resource
{
    protected static ?string $model = Printer::class ;


    protected static ?string $navigationIcon = 'heroicon-o-printer';
    protected static ?string $navigationGroup = 'Configs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                TextInput::make('printer_id')
                    ->label('Serial Number')
                    ->required(),
                BelongsToSelect::make('room_id')
                    ->label('Room')
                    ->relationship('room', 'title')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room.title') // Access room title through relationship
                ->label('Room'),
                TextColumn::make('title')
                    ->label('Title'),
                TextColumn::make('printer_id')
                    ->label('Serial Number'),


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
            'index' => Pages\ListPrinters::route('/'),
            'create' => Pages\CreatePrinter::route('/create'),
            'edit' => Pages\EditPrinter::route('/{record}/edit'),
        ];
    }
}
