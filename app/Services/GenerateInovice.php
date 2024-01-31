<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;

class GenerateInovice
{
    public static function generateTitle()
    {
        return Invoice::whereDate('created_at', today())->count() + 1;
    }

    public static function getInovice($table_id)
    {
        // Get current date components
        $year = date('y');
        $month = date('m');
        $day = date('d');

        // Format table number as two digits
        $table_number = str_pad($table_id, 2, '0', STR_PAD_LEFT);

        // Get the current order count for today (assuming you have a database)
        $order_count = Invoice::whereDate('created_at', today())
            ->when($table_id != null, function ($query) use ($table_id) {
                $query->where('table_id', $table_id);
            })
            ->when($table_id === null, function ($query) {
                $query->whereNull('table_id');
            })
            ->count() + 1;
        $order_today = str_pad($order_count, 4, '0', STR_PAD_LEFT);

        // Concatenate the components to form the invoice string
        $invoice_string = "{$year}{$month}{$day}{$table_number}{$order_today}";

        return $invoice_string;
    }
}