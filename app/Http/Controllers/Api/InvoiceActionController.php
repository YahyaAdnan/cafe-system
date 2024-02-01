<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\InvoiceMigrateRequest;
use App\Http\Requests\InvoiceSeperateRequest;
use App\Http\Requests\InvoiceMoveRequest;
use App\Services\InvoiceAction;
use App\Services\GenerateInovice;
use App\Services\GenerateDailySale;
use App\Http\Controllers\Controller; 
use App\Models\Order;
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

        InvoiceAction::cancelInvoices([
            'invoices' => $invoices,
        ]);

        InvoiceAction::moveOrders([
            'invoices' => $invoices,
            'migrated_invoice' => $migrated_invoice,
        ]);

        $migrated_invoice->updateAmount();

        return response()->json(['message' => 'Migrated Succefully.'], 200);
    }

    /**
    * Separate Invoice into two.
    */

    public function separate(InvoiceSeperateRequest $request)
    {
        if(!Auth::user()->authorized('update invoices'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $invoice =  Invoice::findLocal($request->local_invoice);
        $orders = json_decode($request->orders);

        $new_invoice = Invoice::create([
            'inovice_no' => GenerateInovice::getInovice($invoice->table_id),
            'title' => GenerateInovice::generateTitle(),
            'local_id' =>  $request->new_local_invoice,
            'active' => true,
            'dinning_in' => $invoice->dinning_in,
            'table_id' => $invoice->table_id,
            'amount' => 0,
            'remaining' => 0,
            'discount_rate' => 0,
            'discount_fixed' => 0,
            'note' => '',
        ]);

        GenerateDailySale::getInvoice($new_invoice);

        InvoiceAction::moveOrders([
            'orders' => $orders,
            'migrated_invoice' => $new_invoice,
        ]);

        $new_invoice->updateAmount();
        Invoice::findLocal($request->local_invoice)->updateAmount();

        return response()->json(['message' => 'Separated Succefully.'], 200);
    }

        /**
    * Separate Invoice into two.
    */

    public function move(InvoiceMoveRequest $request)
    {
        if(!Auth::user()->authorized('update invoices'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $orders = json_decode($request->orders);

        InvoiceAction::moveOrders([
            'orders' => $orders,
            'migrated_invoice' => Invoice::findLocal($request->to),
        ]);

        Invoice::findLocal($request->from)->updateAmount();
        Invoice::findLocal($request->to)->updateAmount();

        return response()->json(['message' => 'Moved Succefully.'], 200);
    }
}
