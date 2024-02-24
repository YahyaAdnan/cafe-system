<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliverTypeResource\Pages;
use App\Filament\Resources\DeliverTypeResource\RelationManagers;
use App\Models\DeliverType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class DeliverTypeResource extends Resource
{
    protected static ?string $model = DeliverType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Managment Settings';

    public static function canCreate(): bool
    {
        return Auth::user()->authorized('create daily_sales');
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required()->minLength(3)->maxLength(32),
                Select::make('cash')->options([
                    "1" => "Cash",
                    "0" => "Post-Paid",
                ])->native(false)->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title')->sortable()->searchable(),
                IconColumn::make('cash')->sortable()->boolean(),
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
            ])
            ->checkIfRecordIsSelectableUsing(
                fn(DeliverType $deliverType) => $deliverType->isDeletable()
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
            'index' => Pages\ListDeliverTypes::route('/'),
            'create' => Pages\CreateDeliverType::route('/create'),
            'edit' => Pages\EditDeliverType::route('/{record}/edit'),
        ];
    }
}
