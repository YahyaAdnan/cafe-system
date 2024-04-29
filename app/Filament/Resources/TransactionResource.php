<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Finance';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        // 'amount',
        // 'user_id',
        // 'payment_method_id',
        // 'transactionable_type',
        // 'transactionable_id',
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->sortable(),
                TextColumn::make('amount')
                    ->sortable()
                    ->summarize(Sum::make()),
                TextColumn::make('paymentMethod.title')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Toggle::make('range')->live(),     
                        DatePicker::make('created_at')
                            ->native(false)
                            ->visible(fn(\Filament\Forms\Get $get):bool => !$get('range')),  //IF NOT RANGE
                        DatePicker::make('created_from')
                            ->native(false)
                            ->visible(fn(\Filament\Forms\Get $get):bool => $get('range')),  //IF RANGE
                        DatePicker::make('created_until')
                            ->native(false)
                            ->visible(fn(\Filament\Forms\Get $get):bool => $get('range')), //IF RANGE
                        Select::make('payment_method')->options(PaymentMethod::pluck('title', 'id'))->multiple(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_at'],
                                function (Builder $query, $date) use ($data)
                                {
                                    if($data['range']) {return;}
                                    return $query->whereDate('created_at', '=', $date);
                                }
                            )
                            ->when(
                                $data['created_from'],
                                function (Builder $query, $date) use ($data)
                                {
                                    if(!$data['range']) {return;}
                                    return $query->whereDate('created_at', '>=', $date);
                                }
                            )
                            ->when(
                                $data['created_until'],
                                function (Builder $query, $date) use ($data)
                                {
                                    if(!$data['range']) {return;}
                                    return $query->whereDate('created_at', '<=', $date);
                                }
                            )->when(
                                $data['payment_method'],
                                function (Builder $query, $payment_method)
                                { 
                                    return $query->whereIn('payment_method_id', $payment_method);
                                }
                            );
                        }
                    ),
            ])->searchable();
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
            'index' => Pages\ListTransactions::route('/'),
            // 'create' => Pages\CreateTransaction::route('/create'),
            // 'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
