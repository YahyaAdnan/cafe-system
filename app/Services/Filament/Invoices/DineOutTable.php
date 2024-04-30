<?php
namespace App\Services\Filament\Invoices;

use App\Models\DeliverType;
use App\Models\Employee;
use App\Models\GenerateInovice;
use App\Models\Invoice;
use App\Models\Table as Seat;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use App\Services\InvoiceAction;

class DineOutTable
{    
    public static function make(Table $table)
    {
        return $table
            ->filters([
                SelectFilter::make('deliver_type_id')
                    ->label('Delivery Type')
                    ->options(DeliverType::pluck('title', 'id'))
                    ->multiple(false),
            ])
            ->query(Invoice::where('active', 1)->where('dinning_in', 0))
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('deliverType.title')
                    ->searchable(),
                TextColumn::make('amount')
                    ->badge()
                    ->color("success")
                    ->sortable()
                    ->money('IQD'),
                TextColumn::make('discount_rate')
                    ->label('Fixed Rate')
                    ->suffix('%')
                    ->toggleable(true)
                    ->sortable(),
                TextColumn::make('discount_fixed')
                    ->label('Fixed Discount')
                    ->money('IQD')
                    ->toggleable(true)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->since()
            ])
            // ->bulkActions([
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('Merge_into')
                        ->label('Merge Into')
                        ->form([
                            Select::make('invoice')
                                ->required()
                                ->searchable()
                                ->options(Invoice::where('active', 1)->pluck('title', 'id'))
                        ])
                        ->action(function(Collection $records, array $data){
                            $invoice = InvoiceAction::merge([
                                'invoices' => $records,
                                'invoice' => Invoice::find($data['invoice']),
                            ]);
                            return redirect("invoices/$invoice->id");
                        })
                        ->color('info'),
                    BulkAction::make('merge')
                        ->label('Merge')
                        ->form([
                            Toggle::make('dinning_in')
                                ->default(1)
                                ->label('Dine-In')
                                ->live(),
                            Select::make('table_id')
                                ->label('Table')
                                ->searchable()
                                ->visible(fn(Get $get) => $get('dinning_in'))
                                ->required(fn(Get $get) => $get('dinning_in'))
                                ->options(Seat::pluck('title', 'id')),
                            Select::make('employee_id')
                                ->label('Employee')
                                ->searchable()
                                ->visible(fn(Get $get) => $get('dinning_in'))
                                ->required(fn(Get $get) => $get('dinning_in'))
                                ->options(Employee::pluck('name', 'id')),
                            Select::make('deliver_type_id')
                                ->label('Deliver Type')
                                ->searchable()
                                ->visible(fn(Get $get) => !$get('dinning_in'))
                                ->required(fn(Get $get) => !$get('dinning_in'))
                                ->options(DeliverType::pluck('title', 'id'))
                        ])
                        ->action(function(Collection $records, array $data){
                            $merged = $data['dinning_in'] ?
                                GenerateInovice::dineIn([
                                    'employee_id' => $data['employee_id'],
                                    'table_id' => $data['table_id'],
                                ])
                                : GenerateInovice::dineOut([
                                    'deliver_type_id' => $data['deliver_type_id'],
                                ]);

                            $invoice = InvoiceAction::merge([
                                'invoices' => $records,
                                'invoice' => $merged,
                            ]);
                            return redirect("invoices/$invoice->id");
                        })
                        ->color('success'),
                ])
            ])

            ->recordUrl(fn (Invoice $invoice): string => "invoices/$invoice->id");

    }
}