<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\DailySale;
use App\Models\Employee;
use App\Models\DeliverType;
use App\Models\Table as Seating;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Finance';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->label('Title')->searchable(),
                TextColumn::make('inovice_no')->label('Inovice No')->toggleable(true)->sortable(),
                TextColumn::make('table.title')->toggleable()->sortable(),
                TextColumn::make('amount')->money('IQD')->label('amount')->badge()->color("success")
                    ->money('IQD')->sortable()->summarize([
                        Average::make(),
                        Range::make(),
                        Sum::make(),
                    ]),
                TextColumn::make('remaining')->label('remaining')->badge()
                    ->color(function (Invoice $invoice) {
                        if($invoice->remaining > 0)
                        {
                            return "danger";
                        }
                        return "default";
                    })->money('IQD')->sortable()->toggleable(true)->summarize([
                        Average::make(),
                        Range::make(),
                        Sum::make(),
                    ]),
                TextColumn::make('discount_rate')->label('Fixed Rate')->suffix('%')->toggleable(true)->sortable(),
                TextColumn::make('discount_fixed')->label('Fixed Discount')->money('IQD')->toggleable(true)->sortable(),
                TextColumn::make('created_at')->label('Date')->datetime()->toggleable(true)->sortable(),
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
                    // *** END: FIND BY ORDER DETAILS *** 
                ])->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['daily_sale'],
                            function (Builder $query, $daily_sale) use ($data)
                            {
                                if($data['range']) {return;}
                                $invoices = DailySale::find($daily_sale)->invoices; 
                                return $query->whereIn('id', $invoices->pluck('id'));
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
                                return $query->whereDate('created_until', '<=', $date);
                            }
                        )
                        ->when(
                            $data['deliver_type'],
                            function (Builder $query, $deliver_type_id) use ($data)
                            { 
                                if(!$data['dinning_in'] == 1) {return;}
                                return $query->whereIn('deliver_type_id', $deliver_type_id);
                            }
                        );;
                    }
                ),
                Filter::make('in_debt')
                    ->form([
                        Toggle::make('in_debt'),
                    ])->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['in_debt'],
                                function (Builder $query, $debt) {
                                    if($debt)
                                    {
                                        return $query->where('remaining', '>', "0");
                                    }

                                }
                            );
                    })
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
            'index' => Pages\ListInvoices::route('/'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
            'view' => Pages\ViewInvoice::route('/{record}'),
        ];
    }
}
