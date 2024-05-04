<?php

namespace App\Livewire\Invoice;

use App\Models\Order;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Printer;
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
use App\Services\PrintingService;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Colors\Color;

class NewOrders extends Component implements HasForms
{
    use InteractsWithForms;

    // MODEL.
    public Invoice $invoice;

    public ?array $data = [];
    protected $printService;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
        // adding a deualt item to the repeater
        // since this page is edit the repeaters defaultItems will not work
        $this->form->fill(
            // whole form
            [
                // repeater
                'orders' => [
                    // default item start
                    [
                        "special_order" => false,
                        "extras" => [],
                        "item_id" => null,
                        "title" => null,
                        "quantity" => "1",
                        "amount" => null,
                        "discount" => "0",
                        "total_amount" => null,
                        "note" => null,
                    ]
                    //defult item end
                ]
            ]
        );
    }



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('orders')
                    ->label('')
                    ->schema(OrdersForm::form())
                    ->deleteAction(function (Action $action) {
                        // making it hidden is not working so i just change icon, disable it, make it grey
                        $action->disabled(fn(Get $get) => $get('orders') === null || count($get('orders')) <= 1);
                        $action->color(fn(Get $get) => ($get('orders') === null || count($get('orders')) <= 1) ? Color::Gray:Color::Red);
                        $action->icon(fn(Get $get) => ($get('orders') === null || count($get('orders')) <= 1) ? 'heroicon-m-no-symbol':'heroicon-s-trash');
                    })

                    ->required()
                    ->addActionLabel('Add Order')
                    ->columns(12)
            ])

            ->live()
            ->statePath('data');
    }
    public function create()
    {
        $this->printService = new PrintingService();
        $orderData = $this->form->getState();

        OrdersForm::store([
            'invoice' => $this->invoice,
            'orders' => $orderData['orders'],
        ]);

        if (!empty($orderData['orders'])) {
            $firstOrder = $orderData['orders'][0];
            $item = Item::find($firstOrder['item_id']);
            if ($item) {
                $roomId = $item->getAssociatedRoomConfig();
                $printer = "73300069";
                    $orderContent = "******** ORDER SUMMARY ********\n\n";
                    foreach($orderData['orders'] as $order) {
                        $title = $order['special_order'] ? $order['title'] : Item::find($order['item_id'])->title;
                        $quantity = $order['quantity'];
                        $orderContent .= sprintf("Title: %-20s Quantity: %d\n", $title, $quantity);
                    }
                    $orderContent .= "\n****** THANKS FOR COMING ******";
                    $this->printService->printOrder($printer, $orderContent);

            }
        }

        return redirect('invoices/' . $this->invoice->id);
    }

    public function render()
    {

        return view('livewire.invoice.new-orders');
    }
}
