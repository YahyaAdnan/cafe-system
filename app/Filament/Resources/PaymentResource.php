<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use App\Models\DailySale;
use App\Models\Invoice;
use App\Models\Employee;
use App\Models\DeliverType;
use App\Models\PaymentMethod;
use App\Models\Table as Seating;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Finance';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('payment_method_id')
                    ->required()
                    ->searchable()
                    ->options(PaymentMethod::pluck('title', 'id'))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice.inovice_no')->sortable()->searchable(),
                TextColumn::make('amount')->money('IQD')->sortable()->summarize([
                    Average::make(),
                    Range::make(),
                    Sum::make(),
                ]),
                TextColumn::make('paid')->money('IQD')->toggleable(true)
                ->sortable()->summarize([
                    Average::make(),
                    Range::make(),
                    Sum::make(),
                ]),
                TextColumn::make('remaining')->money('IQD')->label('returned')
                ->toggleable(true)->sortable()->summarize([
                    Average::make(),
                    Range::make(),
                    Sum::make(),
                ]),
                TextColumn::make('paymentMethod.title')->toggleable(true)->sortable(),
                TextColumn::make('user.name')->toggleable(true)->sortable(),
                TextColumn::make('created_at')->sortable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        // *** START: FIND THE DATE *** 
                        Toggle::make('range')->live(),     
                        Select::make('daily_sale')->options(DailySale::pluck('title', 'id'))->searchable()
                            ->visible(fn(Get $get):bool => !$get('range')), //IF RANGE     
                        DatePicker::make('created_from')->visible(fn(\Filament\Forms\Get $get):bool => $get('range')),  //IF RANGE
                        DatePicker::make('created_until')->visible(fn(\Filament\Forms\Get $get):bool => $get('range')), //IF RANGE
                        // *** START: END THE DATE *** 
                        // *** START: FIND BY ORDER DETAILS *** 
                        Select::make('deliver_type')->options(DeliverType::pluck('title', 'id'))->multiple(),
                        Select::make('payment_method')->options(PaymentMethod::pluck('title', 'id'))->multiple(),
                        // *** END: FIND BY ORDER DETAILS *** 
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['daily_sale'],
                                function (Builder $query, $daily_sale) use ($data)
                                {
                                    if($data['range']) {return;}
                                    $invoices = DailySale::find($daily_sale)->invoices; 
                                    return $query->whereIn('invoice_id', $invoices->pluck('id'));
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
                            )
                            ->when(
                                $data['deliver_type'],
                                function (Builder $query, $deliver_type_id) use ($data)
                                { 
                                    if(!$data['dinning_in'] == 1) {return;}
                                    $invoices = Invoice::whereIn('deliver_type_id', $deliver_type_id)->pluck('id');
                                    return $query->whereIn('invoice_id', $invoices);
                                }
                            )
                            ->when(
                                $data['payment_method'],
                                function (Builder $query, $payment_method)
                                { 
                                    return $query->whereIn('payment_method_id', $payment_method);
                                }
                            );
                    }),
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
            'index' => Pages\ListPayments::route('/'),
            // 'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
