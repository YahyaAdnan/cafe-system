<?php

namespace App\Livewire\Cashier;

use App\Services\Filament\Invoices\DineInGrid;
use App\Services\Filament\Invoices\DineInTable;
use App\Services\Filament\Invoices\DineOutGrid;
use App\Services\Filament\Invoices\DineOutTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\On;
use Livewire\Component;

class Tables extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $tableView;
    public $dinein;
    public $renderKey = 0;

    protected $queryString = [
        'tableView' => ['except' => '0'],
        'dinein' => ['except' => '1'],
    ];

    public function mount()
    {
        $this->tableView = session('tableView', '0');
        $this->dinein = session('dinein', '1');
    }

    public function hydrate()
    {
        $this->tableView = session('tableView', $this->tableView);
        $this->dinein = session('dinein', $this->dinein);
    }

    public function updatedTableView($value)
    {
        session(['tableView' => $value]);
        $this->resetTable();
        $this->dispatch('render');
    }

    public function updatedDinein($value)
    {
        session(['dinein' => $value]);
        $this->resetTable();
        $this->dispatch('render');
    }

    private function resetTable()
    {
        $this->renderKey++;
        $this->resetTableFiltersAndSearch();
    }

    private function resetTableFiltersAndSearch()
    {
        $this->tableFilters = [];
        $this->tableSearchQuery = null;
        $this->tableColumnSearches = [];
        $this->tableSortColumn = null;
        $this->tableSortDirection = null;
    }

    public function table(Table $table): Table
    {
        if ($this->tableView === '1') {
            return $this->dinein === '1' ? DineInTable::make($table) : DineOutTable::make($table);
        } else {
            return $this->dinein === '1' ? DineInGrid::make($table) : DineOutGrid::make($table);
        }
    }

    #[On('render')]
    public function render()
    {
        return view('livewire.cashier.tables');
    }
}
