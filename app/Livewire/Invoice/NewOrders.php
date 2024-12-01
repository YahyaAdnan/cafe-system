<?php

namespace App\Livewire\Invoice;

use App\Models\Order;
use App\Models\Price;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Setting;
use App\Models\Printer;
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
use Filament\Support\Enums\ActionSize;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Colors\Color;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Alignment;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Radio;
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


    public function reduceQuantity($selectedOrder)
    {
        $this->data['orders'] = collect($this->data['orders'])
            ->map(function ($order) use ($selectedOrder) {
                if ($order['item_id'] === $selectedOrder['item_id']) {
                    $order['quantity'] = max(0, $order['quantity'] - 1);
                }
                return $order;
            })
            ->filter(fn ($order) => $order['quantity'] > 0)
            ->toArray();
    }

    // *** START: FUNCTION ***
    // $data => array()
    //**  item_id, title, amount **/
    public function selectItem($data)
    {
       $existenOrder = collect($this->data['orders'])->firstWhere('item_id', $data['item_id']);
       if ($existenOrder)
       {
          $this->data['orders'] = collect($this->data['orders'])->map(function ($item) use ($data) {
              if($item['item_id'] == $data['item_id'])
              {
                  $item['quantity'] +=1;
                  return $item;
              }
              return $item;
          })->toArray();
       }else{
           $this->data['orders'][] = [
               "special_order" => true,
               "extras" => [],
               "item_id" => $data['item_id'],
               "title" => $data['title'],
               "quantity" => 1,
               "amount" => $data['amount'],
               "discount" => "0",
               "total_amount" => null,
               "note" => null,
           ];
       }
        ray($this->data['orders']);


    }

    public function table(Table $table): Table
    {
        return OrdersForm::table($table)
            ->recordAction(fn(Item $item) =>  $item->prices->count() > 1 ? 'prices' : 'select')
            ->recordClasses('cursor-pointer hover:bg-gray-50')  // Make entire row clickable
            ->actions([
                Action::make('prices')
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
                Action::make('select')
                    ->label('')
                    ->action(fn(Item $item) => $this->selectItem([
                        'item_id' => $item->prices->first()->id,
                        'title' => $item->title,
                        'amount' => $item->prices->first()->amount,
                    ]))
            ])->headerActions([
                Action::make('special')
                    ->label('Special Order')
                    ->size(ActionSize::Large)
                    ->form(OrdersForm::form()),
                    // TODO: FINISH IT AFTER DEBUGGING, action(fn(array $data) => $this->create()).
                Action::make('submit')
                    ->label('SUBMIT')
                    ->size(ActionSize::Large)
                    ->action(fn() => $this->create())
                    ->disabled(fn() => empty($this->data['orders'])),
            ])->paginated([16, 20, 28, 32, 'all']);;
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

        // $this->printService->printersOrders($orderData);

        return redirect('invoices/' . $this->invoice->id);
    }



    public function render()
    {

        return view('livewire.invoice.new-orders');
    }
}
