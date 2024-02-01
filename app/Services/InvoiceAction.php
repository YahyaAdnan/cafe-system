<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;

class InvoiceAction
{
    public static function moveOrders($inputs) // array{"invoices" => array() or orders => array(),"migrated_invoice" => ''}
    {
        if(isset($inputs['orders']))
        {
            foreach ($inputs['orders'] as $key => $order) 
            {
                Order::findLocal($order)->update([
                    'invoice_id' => $inputs['migrated_invoice']->id
                ]);
            }

            return;
        }

        foreach ($inputs['invoices'] as $key => $local_invoice) 
        {
            $invoice = Invoice::findLocal($local_invoice);
            foreach ($invoice->orders as $key => $order) 
            {
                $order->update([
                    'invoice_id' => $inputs['migrated_invoice']->id
                ]);
            }
        }
    }

    public static function cancelInvoices($inputs) // array{"invoices" => }
    {
        foreach ($inputs['invoices'] as $key => $local_invoice) 
        {
            $invoice = Invoice::findLocal($local_invoice);
            $invoice->cancelInvoice();
        }
    }
    
}