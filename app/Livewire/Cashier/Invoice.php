<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Component 
{
    // MODEL.
    public Model $record;
    // Navigors
    public $selected_nav, $navigators;

    public function mount(Model $record)
    {
        $this->record = $record;

        $this->navigators = array(
            '1' => 'New Orders',
            '2' => 'Orders',
            '3' => 'Payments',
        );
        $this->selected_nav = 1;
    }

    public function render()
    {
        return view('livewire.cashier.invoice');
    }
}
