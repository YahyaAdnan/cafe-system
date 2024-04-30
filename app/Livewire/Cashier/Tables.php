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

class Tables extends Component  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $view = 1, $invoice = 1, $renderCount = 0;

    public $viewType = array(
        '1' => 'Grid',
        '2' => 'Table',
    );

    public $invoiceTypes = array(
        '1' => 'Dine-in',
        '2' => 'Dine-out',
    );

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

    public function table(Table $table): Table
    {
        $this->viewTitle = $this->viewType[$this->view];
        $this->invoiceTitle = $this->invoiceTypes[$this->invoice];

        if($this->view == 1)
        {
            if($this->invoice == 1)
            {
                return DineInGrid::make($table);
            } else if($this->invoice == 2)
            {
                return  DineOutGrid::make($table);
            }
        }

        if($this->view == 2)
        {
            if($this->invoice == 1)
            {
                return DineInTable::make($table);
            }
            if($this->invoice == 2)
            {
                return DineOutTable::make($table);
            }
        }
    }

    #[On('render')]
    public function render()
    {
        return view('livewire.cashier.tables');
    }
}
