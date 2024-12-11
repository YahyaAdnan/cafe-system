<?php

namespace App\Livewire\Cashier;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Invoice extends Component 
{
    // MODEL.
    public Model $record;
    // Navigors
    public $selected_nav, $navigators;

    public function mount(Model $record)
    {
        $this->record = $record;

        $this->getNavigators();

        $this->selected_nav = 1;
    }

    public function getNavigators()
    {
        $this->navigators = array();

        if(Auth::user()->authorized('create orders'))
        {
            $this->navigators[1] = 'New Orders';
        }

        if(Auth::user()->authorized('list orders'))
        {
            $this->navigators[2] = 'Orders';
        }

        // if(Auth::user()->authorized('create payments'))
        // {
        //     $this->navigators[3] = 'Payments';
        // }
    }

    public function render()
    {
        return view('livewire.cashier.invoice');
    }
}
