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

    public function table(Table $table): Table
    {
        return DineInGrid::make($table);
    }

    public function render()
    {
        return view('livewire.cashier.tables');
    }
}
