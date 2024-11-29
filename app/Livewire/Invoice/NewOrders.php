<?php

namespace App\Livewire\Invoice;

use App\Models\Order;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Printer;
use App\Models\Setting;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\Filament\OrdersForm;
use App\Services\EstimatePrice;
use Livewire\Component;
use App\Services\PrintingService;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Colors\Color;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Builder;


class NewOrders extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    // MODEL.
    public Invoice $invoice;

    public ?array $data = [];
    protected $printService;

    public function mount(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->data = [
            // repeater
            'orders' => [
            ]
        ];
        // adding a deualt item to the repeater
        // since this page is edit the repeaters defaultItems will not work
        $this->form->fill($this->data);
    }

    // *** START: FUNCTION ***
    // $data => array()
    //**  item_id, title, amount **/
    public function selectItem($data)
    {

        $dataFound = false;
        foreach ($this->data['orders'] as &$order){
            if ($data['item_id'] == $order['item_id']){
                $order['quantity']=(int)$order['quantity'] + 1;
                $dataFound = true;
                break;
            };
        }

       if (!$dataFound){
           $this->data['orders'][] = [
               "special_order" => true,
               "extras" => [],
               "item_id" => $data['item_id'],
               "title" => $data['title'],
               "quantity" =>1,
               "amount" => $data['amount'],
               "discount" => "0",
               "total_amount" => null,
               "note" => null,
           ];
       }

    }


    public function reduceQuantity($itemId)
    {
        foreach ($this->data['orders'] as &$order) {
            if ($order['item_id'] == $itemId) {
                if ($order['quantity'] > 1) {
                    $order['quantity'] = (int)$order['quantity'] - 1;
                }else{
                    $this->data['orders'] = array_filter($this->data['orders'], function ($item) use ($itemId) {
                        return $item['item_id'] != $itemId;
                    });
                }
                break;
            }
        }

    }
    public function table(Table $table): Table
    {
        return OrdersForm::table($table)
            ->recordAction(fn(Item $item) =>  $item->prices->count() > 1 ? 'prices' : 'select')
            ->actions([
                TableAction::make('prices')
                    ->label('')
                    ->form([
                        Radio::make('price_id')
                            ->label('Price')
                            ->options(fn(Item $item) => $item->prices->pluck('title', 'id'))
                            ->required(),
                    ])
                    ->action(function (array $data, Item $item): void {
                        $this->selectItem([
                            'item_id' => $item->prices->first()->id,
                            'title' => $item->title . ' (' . Price::find($data['price_id'])->title . ')',
                            'amount' => $item->prices->first()->amount,
                        ]);
                    }),
                TableAction::make('select')
                    ->label('')
                    ->action(fn(Item $item) => $this->selectItem([
                        'item_id' => $item->prices->first()->id,
                        'title' => $item->title,
                        'amount' => $item->prices->first()->amount,
                    ]))
            ])->headerActions([
                Action::make('submit')
                    ->label('SUBMIT')
                    ->size(ActionSize::Large)
                    ->action(fn() => $this->create()),
            ])->paginated([16, 20, 28, 32, 'all']);
    }

    public function create()
    {
        $this->printService = new PrintingService();
        $orderData = $this->form->getState();

        /**
         * must use $this->form->getState() to validate and get data
         * using $this->data is fine but it wont validate while form->getState() validates then returns the data
         * so u can store it inside a variable and treat it like $this->data
         */
        OrdersForm::store([
            'invoice' => $this->invoice,
            'orders' => $this->data['orders'],
        ]);

        // TODO: FOR PRINT RECEIPT.
        // $this->printService->printersOrders($orderData);

        return redirect('invoices/' . $this->invoice->id);
    }



    public function render()
    {

        return view('livewire.invoice.new-orders');
    }
}
