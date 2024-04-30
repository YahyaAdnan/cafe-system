<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('expense_category_id')
                    ->label('Expense Category')
                    ->columnSpan(['sm' => 12, 'md' => 6])
                    ->options(ExpenseCategory::pluck('title', 'id'))
                    ->required()
                    ->searchable(),
                DatePicker::make('date')
                    ->native(false)
                    ->columnSpan(['sm' => 12, 'md' => 6])
                    ->required()
                    ->maxDate(now()),
                Select::make('payment_method_id')
                    ->columnSpan(['sm' => 12, 'md' => 6])
                    ->label('Payment Method')
                    ->options(PaymentMethod::pluck('title', 'id'))
                    ->required()
                    ->searchable(),
                TextInput::make('amount')
                    ->suffix("IQD")
                    ->columnSpan(['sm' => 12, 'md' => 6])
                    ->required()
                    ->minValue(0)
                    ->maxValue(1000000000),
                TextInput::make('note')
                    ->columnSpan(12)
                    ->maxLength(64)
            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('expenseCategory.title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('IQD')
                    ->sortable()
                    ->summarize([
                        Average::make(),
                        Range::make(),
                        Sum::make(),
                    ]),
                TextColumn::make('paymentMethod.title')
                    ->sortable(),
                TextColumn::make('date')
                    ->sortable(),
                TextColumn::make('note')
                    ->toggleable()
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
                        Select::make('expense_category')
                            ->options(ExpenseCategory::pluck('title', 'id'))
                            ->multiple(),
                        Select::make('payment_method')
                            ->options(PaymentMethod::pluck('title', 'id'))
                            ->multiple(),
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
                                $data['expense_category'],
                                function (Builder $query, $expense_category)
                                { 
                                    return $query->whereIn('expense_category_id', $expense_category);
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->checkIfRecordIsSelectableUsing(
                fn(Expense $expense) => $expense->isDeletable()
            );
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
