<?php
namespace App\Services\Filament\Invoices;

use App\Models\Employee;
use App\Models\Table as Seat;
use App\Services\GenerateInovice;
use App\Models\DeliverType;
use Filament\Forms\Components\Radio;
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
            ->query(Seat::where(function ($query) {
                $query->where('title', '!=', '#')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('title', '#')
                            ->whereExists(function ($nestedQuery) {
                                $nestedQuery->select('id')
                                    ->from('invoices')
                                    ->whereColumn('invoices.table_id', 'tables.id')
                                    ->where('active', true);
                            });
                    });
                })->orderByRaw("CASE WHEN title = '#' THEN 0 ELSE 1 END")
                ->orderByRaw("CAST(title AS UNSIGNED)")
            )
            ->columns([
                // START: THE GRID OF TABLES.
                Grid::make()
                ->columns(1)
                ->schema([
                    TextColumn::make('title')
                        ->color(fn(Seat $seat) =>  $seat->activeInvoicesCount() > 0 ? 'success' : '')
                        ->size(fn(Seat $seat) =>  $seat->activeInvoicesCount() > 0 
                            ? TextColumn\TextColumnSize::Large
                            : TextColumn\TextColumnSize::Medium
                        )
                        ->weight(fn(Seat $seat) =>  $seat->activeInvoicesCount() > 0 
                            ? FontWeight::Black
                            : FontWeight::Thin
                        )
                        ->alignment('center')
                        ->searchable(),
                    ViewColumn::make('ActiveInvoices')->view('tables.columns.invoices-column')
                ])
                // END: THE GRID OF TABLES.
            ])
            ->contentGrid(['md' => 2, 'xl' => 3])
            ->paginated(false)
            ->recordAction(fn(Seat $seat) => $seat->activeInvoicesCount() == 0 ? 'create' : Tables\Actions\ViewAction::class)
            ->actions([
                Action::make('create')
                    ->label('New Invoice')
                    ->icon('heroicon-s-plus')
                    ->size(ActionSize::Large)
                    ->form([
                        Radio::make('employee_id')
                            ->label('employee')
                            ->default(fn(Seat $seat) => $seat->invoices->where('active', 1)->first()?->employee_id)
                            ->options(Employee::pluck('name', 'id'))
                            ->required(),
                    ])->action(function (array $data, Seat $seat) {
                        $invoice = GenerateInovice::dineIn([
                            'table_id' => $seat->id,
                            'employee_id' => $data['employee_id'],
                        ]);
                        return redirect('invoices/' . $invoice->id);
                    }),
            ], position: ActionsPosition::BeforeColumns)
            ->headerActions([
                Action::make('create')
                    ->label('Take Away')
                    ->icon('heroicon-s-plus')
                    ->size(ActionSize::Large)
                    ->form([
                        Select::make('deliver_type_id')
                            ->searchable()
                            ->label('Deliver Type')
                            ->options(DeliverType::pluck('title', 'id'))
                            ->required(),
                    ])->action(function (array $data, Seat $seat): void {
                        $invoice = GenerateInovice::dineOut([
                            'deliver_type_id' => $data['deliver_type_id'],
                        ]);
                    }),
            ]);

    }
}