<?php
namespace App\Services\Filament\Invoices;

use App\Models\Employee;
use App\Models\GenerateInovice;
use App\Models\Table as Seat;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Table;

class DineInGrid
{
    public static function make(Table $table)
    {
        return $table
            ->query(Seat::query())
            ->columns([
                // START: THE GRID OF TABLES.
                Grid::make()
                ->columns(1)
                ->schema([
                    TextColumn::make('title')
                        ->size(TextColumn\TextColumnSize::Large)
                        ->weight(FontWeight::Bold)
                        ->alignment('center')
                        ->searchable(),
                    ViewColumn::make('ActiveInvoices')->view('tables.columns.invoices-column')
                ])
                // END: THE GRID OF TABLES.
            ])
            ->contentGrid(['md' => 2, 'xl' => 3])
            ->paginated(false)
            ->actions([
                Action::make('create')
                    ->label('New Invoice')
                    ->icon('heroicon-s-plus')
                    ->size(ActionSize::Large)
                    ->form([
                        Select::make('employee_id')
                            ->searchable()
                            ->label('employee')
                            ->options(Employee::pluck('name', 'id'))
                            ->required(),
                    ])->action(function (array $data, Seat $seat): void {
                        $invoice = GenerateInovice::dineIn([
                            'table_id' => $seat->id,
                            'employee_id' => $data['employee_id'],
                        ]);
                    }),
            ], position: ActionsPosition::BeforeColumns);

    }
}