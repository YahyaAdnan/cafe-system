<?php

namespace App\Livewire\Cashier;

use Livewire\Attributes\On;
use Livewire\Component;
use App\Services\GenerateInovice;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\ActionSize;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Contracts\View\View;
use App\Models\Table as Seat;
use App\Models\Employee;
use App\Models\Invoice;
use App\Models\DeliverType;

class Tables extends Component  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $view = 1, $invoice = 1,$renderCount = 0;


    public function updatedView()
    {
        $this->dispatch('render');
        $this->render(); // First render
    }

    public function updatedInvoice()
    {
        $this->dispatch('render');
        $this->render(); // First render
    }

    public $viewType = array(
        '1' => 'Grid',
        '2' => 'Table',
    );

    public $invoiceTypes = array(
        '1' => 'Dine-in',
        '2' => 'Dine-out',
    );



    public function table(Table $table): Table
    {
        $this->viewTitle = $this->viewType[$this->view];
        $this->invoiceTitle = $this->invoiceTypes[$this->invoice];

        if($this->view == 1)
        {
            if($this->invoice == 1)
            {
                return $this->dineInGrid($table);
            } else if($this->invoice == 2)
            {
                return $this->dineOutGrid($table);
            }
        }

        if($this->view == 2)
        {
            if($this->invoice == 1)
            {
                return $this->dineInTable($table);
            }
            if($this->invoice == 2)
            {
                return $this->dineOutTable($table);
            }
        }
    }

    private function dineInGrid(Table $table)
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

    private function dineOutGrid(Table $table)
    {
        return $table
            ->query(Invoice::where('active', 1)->where('dinning_in', 0))
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
                    TextColumn::make('deliverType.title')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->weight(FontWeight::Light)
                        ->alignment('left')
                        ->searchable(),
                    TextColumn::make('amount')
                        ->prefix('Money: ')
                        ->money('IQD')
                        ->size(TextColumn\TextColumnSize::Medium)
                        ->weight(FontWeight::Light)
                        ->alignment('left')
                        ->searchable(),
                ])
                // END: THE GRID OF TABLES.
            ])
            ->headerActions([
                Action::make('create')
                    ->label('New Invoice')
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
            ])
            ->recordUrl(fn (Invoice $invoice): string => "invoices/$invoice->id")
            ->contentGrid(['md' => 2, 'xl' => 3])
            ->paginated(false);
    }

    private function dineOutTable(Table $table)
    {
        return $table
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
            ->filters([
                SelectFilter::make('deliver_type_id')
                    ->label('Deliver Type')
                    ->multiple()
                    ->options(DeliverType::pluck('title', 'id'))
            ])
            ->recordUrl(fn (Invoice $invoice): string => "invoices/$invoice->id");
    }

    private function dineInTable(Table $table)
    {
        return $table
            ->query(Invoice::where('active', 1)->where('dinning_in', 1))
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('table.title')
                    ->searchable(),
                TextColumn::make('employee.name')
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
            ->filters([
                SelectFilter::make('table_id')
                    ->label('Table')
                    ->multiple()
                    ->options(Seat::pluck('title', 'id')),
                SelectFilter::make('employee_id')
                    ->label('Employee')
                    ->multiple()
                    ->options(Employee::pluck('name', 'id')),
            ])
            ->recordUrl(fn (Invoice $invoice): string => "invoices/$invoice->id");
    }

    #[On('render')]
    public function render()
    {
        return view('livewire.cashier.tables');
    }
}
