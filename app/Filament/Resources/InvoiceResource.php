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

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->label('Title')->searchable(),
                TextColumn::make('inovice_no')->label('Inovice No')->toggleable(true)->sortable(),
                TextColumn::make('table.title')->toggleable()->sortable(),
                TextColumn::make('amount')->label('amount')->badge()->color("success")
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
                    Select::make('dinning_in')->options([
                        0 => "ANY",
                        1 => "OUT-ORDER",
                        2 => "DIN-IN",
                    ])->native(false)->live(),
                    Select::make('tables')->options(Seating::pluck('title', 'id'))->multiple()
                        ->visible(fn(Get $get):bool => $get('dinning_in') == 2),
                    Select::make('employees')->options(Employee::pluck('name', 'id'))->multiple()
                        ->visible(fn(Get $get):bool => $get('dinning_in') == 2),
                    Select::make('deliver_type')->options(DeliverType::pluck('title', 'id'))->multiple()
                        ->visible(fn(Get $get):bool => $get('dinning_in') == 1),
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
                            $data['dinning_in'],
                            function (Builder $query, $dinning_in)
                            {
                                // IF dinning_is 1 then 1-1 = false, while dinning in val is 2 so 2-1 = 1 true.
                                return $query->where('dinning_in', (int)$dinning_in - 1);
                            }
                        )
                        ->when(
                            $data['tables'],
                            function (Builder $query, $tables_id) use ($data)
                            { 
                                if(!$data['dinning_in'] == 2) {return;}
                                return $query->whereIn('table_id', $tables_id);
                            }
                        )
                        ->when(
                            $data['employees'],
                            function (Builder $query, $employee_id) use ($data)
                            { 
                                if(!$data['dinning_in'] == 2) {return;}
                                return $query->whereIn('employee_id', $employee_id);
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
            // 'inovice_no',
            // 'title',
            // 'local_id',
            // 'active',
            // 'dinning_in',
            // 'table_id',
            // 'amount',
            // 'remaining',
            // 'discount_rate',
            // 'discount_fixed',
            // 'note',
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
        ];
    }
}
