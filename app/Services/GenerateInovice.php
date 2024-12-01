<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Table;

class GenerateInovice
{

    // data => {employee_id, table_id}
    public static function dineIn($data)
    {
        return Invoice::create([
            'inovice_no' => GenerateInovice:: getInovice($data['table_id']),
            'title' => GenerateInovice::generateTitle(),
            'active' => 1,
            'dinning_in' => 1,
            'table_id' => $data['table_id'],
            'amount' => 0,
            'remaining' => 0,
            'discount_rate' => 0,
            'discount_fixed' => 0,
            'employee_id' => $data['employee_id'],
        ]);
    }

    public static function dineOut($data)
    {
        return Invoice::create([
            'inovice_no' => GenerateInovice:: getInovice(null),
            'title' => GenerateInovice::generateTitle(),
            'active' => 1,
            'dinning_in' => 0,
            'table_id' => Table::takeAway()->id,
            'amount' => 0,
            'remaining' => 0,
            'discount_rate' => 0,
            'discount_fixed' => 0,
            'deliver_type_id' => $data['deliver_type_id']
        ]);
    }

    public static function generateTitle()
    {
        return Invoice::whereDate('created_at', today())->count() + 1;
    }

    public static function getInovice($table_id)
    {
        // Get current date components
        $year = date('y'); //24
        $month = date('m'); //02
        $day = date('d'); //24

        // Format table number as two digits
        $table_number = str_pad($table_id, 2, '0', STR_PAD_LEFT);
        //240224

        // Get the current order count for today (assuming you have a database)
        // Table_id -> 3
        // count of invoices for this table today
        // else
        // count invoices without table_id
        $order_count = Invoice::whereDate('created_at', today())
            ->when($table_id != null, function ($query) use ($table_id) {
                $query->where('table_id', $table_id);
            })
            ->when($table_id === null, function ($query) {
                $query->whereNull('table_id');
            })
            ->count() + 1;
        $order_today = str_pad($order_count, 4, '0', STR_PAD_LEFT);
        //24 02 24 03 0001
        //Y  M  D  T  order num
        // Concatenate the components to form the invoice string
        $invoice_string = "{$year}{$month}{$day}{$table_number}{$order_today}";

        return $invoice_string;
    }
}