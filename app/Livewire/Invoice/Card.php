<?php

namespace App\Livewire\Invoice;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use Livewire\Component;
use App\Services\GenerateReceipt;

class Card extends Component
{
    // MODEL.
    public Invoice $invoice;
    public $selectedLanguage = 'title_en'; // Default language
    public $receiptData;
    public function mount(Model $record)
    {
        $this->invoice = $record;
    }

    public function done()
    {
        if($this->invoice->remaining != 0)
        {
            return;
        }

        $this->invoice->update([
            'active' => 0
        ]);

        return redirect('tables-cashier');
    }

    public function generateReceipt()
    {
        // Prepare the data array required by GenerateReceipt::generate
        $data = [
            'lang' => $this->selectedLanguage, // Assuming 'lang' expects 'title', 'title_ar', or 'title_ku'
            'invoice' => $this->invoice,
        ];

        // Call the GenerateReceipt service and store the result
        $receiptData = GenerateReceipt::generate($data);
        ray($receiptData)->label('local recipt')->red();
        // Now $receiptData contains the array returned by GenerateReceipt::generate
        // You can use $receiptData to display the receipt information in your Livewire view
        // For example, you can set it as a public property or pass it to the view directly

        $this->receiptData = $receiptData;
    }



    public function render()
    {
        $this->generateReceipt();
        return view('livewire.invoice.card');
    }
}
