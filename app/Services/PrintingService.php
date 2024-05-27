<?php
namespace App\Services;
use Rawilk\Printing\Printing;
use App\Models\Price;
use App\Models\Item;
use App\Models\Printer;
use Rawilk\Printing\Receipts\ReceiptPrinter;

class PrintingService
{
    public function printOrder($printerId, $orderContent)
    {
        try {
            $printing = app(Printing::class);

            $textToPrint = "Order Content: " . $orderContent . "\n";
    
            $printing->newPrintTask()
                ->printer($printerId)
                ->content($textToPrint) // Chain methods
                ->send();
        } catch (\Throwable $th) {
            return;
        }
    }

    protected function generateReceiptContent($data)
    {
        $receiptContent = ""; // Initialize receipt content

        foreach($data as $order) {
            $title = !$order['item_id'] 
                ? $order['title'] 
                : Price::find($order['item_id'])->item->title . ' (' . Price::find($order['item_id'])->title . ')' ;
            $quantity = $order['quantity'];
            $receiptContent .= "Title: $title X Quantity: $quantity\n";
        }

        // Add any additional content to the receipt here
        $receiptContent .= "Thank you for your order!\n";

        // Assuming the ReceiptPrinter class or similar functionality is available
        // You might need to replace this with the actual method to generate receipt content
        $receipt = (new ReceiptPrinter())
            ->centerAlign()
            ->text('Central Perk')
            ->line()
            ->leftAlign()
            ->text($receiptContent)
            ->cut();

        return (string) $receipt;
    }

    public function printersOrders($data)
    {
        $printersOrders = [];

        foreach($data['orders'] as $order)
        {
                $item = Price::find($order['item_id'])->item;
                $roomId = $item->getAssociatedRoomConfig();
                // $printer = Printer::where('room_id', $roomId)->first();
                // $printerID = $printer->printer_id;
    
                $printersOrders[$roomId][] = $order;
        }


        foreach($printersOrders as $roomId => $orders)
        {
            $content = $this->generateReceiptContent($orders);
            $printerID = Printer::where('room_id',$roomId)->first()->printer_id;
            $this->printOrder($printerID, $content);
        }
    }
}

?>
