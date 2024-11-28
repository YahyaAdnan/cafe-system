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
use App\Models\Table as Seat;
use Livewire\Component;

class Tables extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public function table(Table $table): Table
    {
        // if ($this->tableView === '1') {
        //     return $this->dinein === '1' ? DineInTable::make($table) : DineOutTable::make($table);
        // } else {
        //     return $this->dinein === '1' ? DineInGrid::make($table) : DineOutGrid::make($table);
        // }
        return DineOutGrid::make($table);
    }

    public function render()
    {
        return view('livewire.cashier.tables');
    }
}
