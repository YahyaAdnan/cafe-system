<?php
namespace App\Services;
use Rawilk\Printing\Printing;
use App\Models\Price;
use App\Models\Item;
use App\Models\Printer;
use Rawilk\Printing\Receipts\ReceiptPrinter;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer as PrinterZ;
use Illuminate\Support\Facades\Http;
use Mike42\Escpos\Printer as EscposPrinter;
class PrintingService
{
    protected $windowsPrintServerUrl;
    public function __construct()
    {
        $this->windowsPrintServerUrl = env('WINDOWS_PRINT_SERVER_URL', 'http://cafe-windows-pc:8000');
    }

    public function getPrinters()
    {
        $response = Http::get($this->windowsPrintServerUrl . '/printers');

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Failed to get printers: ' . $response->body());
        }
    }

    public function printOrder($printerId, $orderContent)
    {

        $escposCommands = $this->convertToEscpos($orderContent);


        $response = Http::post($this->windowsPrintServerUrl . '/print', [
            'printer' => $printerId,
            'content' => $escposCommands
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Print job failed: ' . $response->body());
        }

    }

    protected function convertToEscpos($rawilkReceipt)
    {
        // Create a virtual connector to capture ESC/POS commands
        $connector = new NetworkPrintConnector('localhost', 9100);
        $printer = new EscposPrinter($connector);

        // Convert Rawilk commands to ESC/POS
        $lines = explode("\n", $rawilkReceipt);
        foreach ($lines as $line) {
            if (strpos($line, 'CENTER') !== false) {
                $printer->setJustification(EscposPrinter::JUSTIFY_CENTER);
            } elseif (strpos($line, 'LEFT') !== false) {
                $printer->setJustification(EscposPrinter::JUSTIFY_LEFT);
            } elseif (strpos($line, 'RIGHT') !== false) {
                $printer->setJustification(EscposPrinter::JUSTIFY_RIGHT);
            } elseif (strpos($line, 'CUT') !== false) {
                $printer->cut();
            } else {
                $printer->text($line . "\n");
            }
        }

        // Get the generated ESC/POS commands
        $escposCommands = $connector->getData();

        // Close the connector without actually printing
        $connector->finalize();

        return $escposCommands;
    }

    protected function generateReceiptContent($data)
    {
        $receipt = (new ReceiptPrinter())
            ->centerAlign()
            ->text('Central Perk')
            ->line()
            ->leftAlign();

        foreach($data as $order) {
            $title = $order['special_order'] ? $order['title'] : Price::find($order['item_id'])->item->title;
            $quantity = $order['quantity'];
            $receipt->text("Title: $title X Quantity: $quantity");
        }

        $receipt->line()
            ->text('Thank you for your order!')
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
            $printer = Printer::where('room_id', $roomId)->first();
            if ($printer) {
                $this->printOrder($printer->printer_id, $content);
            } else {
                \Log::warning("No printer found for room ID: $roomId");
            }

        }
    }
}

?>
