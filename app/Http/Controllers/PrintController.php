<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rawilk\Printing\Printing;

class PrintController extends Controller
{

    public function testPrint()
    {
        $printing = app(Printing::class);
        $printerId = "73259189";

        $textToPrint = "This is a test print from Laravel with ID: " . $printerId . "\n"; // Add line break and ID

        // Format text if necessary (check package documentation for details)

//        $printing->newPrintTask()
//            ->printer($printerId)
//            ->content($textToPrint) // Chain methods
//            ->send();
        return $textToPrint;

    }
}
