<?php
namespace App\Services;
use Rawilk\Printing\Printing;

class PrintingService
{
    public function printOrder($printerId, $orderContent)
    {
        $printing = app(Printing::class);

        $textToPrint = "Order Content: " . $orderContent . "\n";

        $printing->newPrintTask()
            ->printer($printerId)
            ->content($textToPrint) // Chain methods
            ->send();

    }
}

?>
