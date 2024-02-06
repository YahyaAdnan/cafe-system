<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use App\Models\Table as Seating;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Range;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                TextColumn::make('title')->label('Title')->searchable(),
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
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('table_id')->label('Table')->searchable()
                    ->options(Seating::pluck('title', 'id')),
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
