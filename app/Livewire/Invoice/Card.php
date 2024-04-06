<?php

namespace App\Livewire\Invoice;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use Livewire\Component;

class Card extends Component
{
    // MODEL.
    public Invoice $invoice;

    public function mount(Model $record)
    {
        $this->invoice = $record;
    }    
        
    public function render()
    {
        return view('livewire.invoice.card');
    }
}
