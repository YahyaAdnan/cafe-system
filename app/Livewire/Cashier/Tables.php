<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use App\Services\GenerateInovice;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\View\View;
use App\Models\Table as Seat;
use App\Models\Employee;
use App\Models\Invoice;

class Tables extends Component  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
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
                Action::make('edit')
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
            ], position: ActionsPosition::BeforeColumns)
            ->bulkActions([
                
            ]);
    }

    public function render()
    {
        return view('livewire.cashier.tables');
    }
}
