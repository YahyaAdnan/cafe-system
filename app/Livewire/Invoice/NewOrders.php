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
        if (isset($this->data['orders']) ){
            foreach ($this->data['orders'] as $key => $order)
            {
                for ($i=0; $i < $order['quantity']; $i++)
                {
                    if($order['special_order'])
                    {
                        Order::create([
                            'invoice_id' => $this->invoice->id,
                            'title' => $order['title'],
                            'user_id' => Auth::id(),
                            'amount' => $order['amount'],
                            'total_amount' => $order['amount'],
                            'discount_fixed' => 0,
                            'note' => $order['note'],
                        ]);
                    }
                    else
                    {
                        $price = Price::find($order['item_id']);
                        $item = $price->item;

                        Order::create([
                            'invoice_id' => $this->invoice->id,
                            'title' => $item->title,
                            'item_id' => $item->id,
                            'price_id' => $price->id,
                            'user_id' => Auth::id(),
                            'amount' => $price->amount,
                            'discount_fixed' => $order['discount'],
                            'total_amount' => $price->amount -  $order['discount'],
                            'note' =>  $order['note'],
                        ]);
                    }
                }
            }

            // UPDATE THE AMOUNT OF THE INVOICE
            Invoice::find($this->invoice->id)->updateAmount();
        }

        return redirect('invoices/' . $this->invoice->id);
    }

    public function render()
    {
        return view('livewire.invoice.new-orders');
    }
}
