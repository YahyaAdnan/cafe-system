<?php

namespace App\Livewire\Invoice;

use App\Models\Order;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\Item;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Filament\OrdersForm;
use App\Services\EstimatePrice;
use Livewire\Component;

class NewOrders extends Component implements HasForms
{
    use InteractsWithForms;

    // MODEL.
    public Invoice $invoice;

    public ?array $data = [];

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('orders')
                ->label('')
                ->schema(OrdersForm::form())
                ->addActionLabel('Add Order')
                ->columns(12)
            ])
            ->statePath('data');
    }

    public function create()
    {
        $this->form->getState();
        /**
         * must use $this->form->getState() to validate and get data
         * using $this->data is fine but it wont validate while form->getState() validates then returns the data 
         * so u can store it inside a variable and treat it like $this->data
         */
        OrdersForm::store([
            'invoice' => $this->invoice,
            'orders' => $this->data['orders'],
        ]);

        return redirect('invoices/' . $this->invoice->id);
    }

    public function render()
    {
        return view('livewire.invoice.new-orders');
    }
}
