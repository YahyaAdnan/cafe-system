<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Services\GenerateInovice;
use App\Services\GenerateDailySale;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(InvoiceStoreRequest $request)
    {
        if(!Auth::user()->authorized('create invoices'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $invoice = Invoice::create([
            'inovice_no' => GenerateInovice::getInovice($request->table_id),
            'title' => GenerateInovice::generateTitle(),
            'local_id' =>  $request->local_id,
            'active' => true,
            'dinning_in' => $request->dinning_in,
            'table_id' => $request->table_id,
            'amount' => 0,
            'remaining' => 0,
            'discount_rate' => 0,
            'discount_fixed' => 0,
            'discount_fixed' => $request->employee_id,
            'deliver_type_id' => $request->deliver_type_id,
            'note' => '',
        ]);

        GenerateDailySale::getInvoice($invoice);

        return response()->json(['invoice' => $invoice], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvoiceUpdateRequest $request, $local_invoice)
    {
        if(!Auth::user()->authorized('update invoices'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $invoice = Invoice::findLocal($local_invoice);
        
        $validated = $request->validated();

        $invoice->update($validated);
        $invoice->updateAmount();

        return response()->json(['invoice' => $invoice], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($local_invoice)
    {
        if(!Auth::user()->authorized('delete invoices'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $invoice = Invoice::findLocal($local_invoice);
        $invoice->delete();
        
        return response()->json(['invoice' => $invoice], 200);
    }
}
