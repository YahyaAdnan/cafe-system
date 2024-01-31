<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\InvoiceMigrateRequest;
use App\Http\Controllers\Controller; 
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceActionController extends Controller
{
    /**
    * Migrate Muiltiple Invoices into one.
    */

    public function migrate(InvoiceMigrateRequest $request)
    {
        if(!Auth::user()->authorized('update invoices'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $invoices = json_decode($request->invoices);
        $migrated_invoice =  Invoice::findLocal($request->migrated_to);

        $this->invoices_migrate([
            'invoices' => $invoices,
            'migrated_invoice' => $migrated_invoice,
        ]);

        $migrated_invoice->updateAmount();

        return response()->json(['message' => 'Migrated Succefully.'], 200);
    }

    private function invoices_migrate($inputs) // array{"invoices" => '', "migrated_invoice" => ''}
    {
        foreach ($inputs['invoices'] as $key => $local_invoice) 
        {
            $invoice = Invoice::findLocal($local_invoice);

            foreach ($invoice->orders as $key => $order) 
            {
                $order->update([
                    'invoice_id' => $inputs['migrated_invoice']->id
                ]);
            }

            $invoice->cancelInvoice();
        }
    }
}
