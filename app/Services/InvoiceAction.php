<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;

class InvoiceAction
{
    // $data {"orders" => collection(), "invoice" => Invoice()}
    public static function split($data)
    {
        $old_invoice = $data['invoice'];

        $new_invoice = $old_invoice->dinning_in ? 
            GenerateInovice::dineIn([
                'employee_id' => $old_invoice->employee_id, 
                'table_id' => $old_invoice->old_invoice, 
            ]) : GenerateInovice::dineOut([
                'deliver_type_id' => $old_invoice->deliver_type_id, 
            ]);

        foreach ($data['orders'] as $key => $order) 
        {
            $order->update([
                'invoice_id' => $new_invoice->id
            ]); 
        }

        Invoice::find($old_invoice->id)->updateAmount();
        Invoice::find($new_invoice->id)->updateAmount();

        return $new_invoice;
    }

    // $data {"invoices" => collection(), "invoice" => Invoice()}
    public static function merge($data)
    {
        $merged = $data['invoice'];

        foreach ($data['invoices'] as $key => $invoice) 
        { 
            if($merged->id == $invoice->id)
            {
                continue;
            }

            InvoiceAction::move([
                'orders' => $invoice->orders,
                'to' => $merged->id 
            ]);

            $invoice->cancelInvoice();
        }

        Invoice::find($merged->id)->updateAmount();

        return $merged;
    }

    // $data {"orders" => collection(), "to" => Invoice()}
    public static function move($data) 
    {
        $to = $data['to'];

        foreach ($data['orders'] as $key => $order) 
        {
            $from = $order->invoice_id;

            $order->update([
                'invoice_id' => $to
            ]);

            Invoice::find($from)->updateAmount();
        }

        Invoice::find($to)->updateAmount();

        return Invoice::find($to);
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