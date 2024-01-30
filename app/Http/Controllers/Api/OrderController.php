<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request)
    {
        if(!Auth::user()->authorized('update orders'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $validated = $request->validated();
        $invoice = Invoice::findLocal($request->local_invoice);

        $validated['invoice_id'] = $invoice->id;
        $validated['user_id'] = Auth::id();
        $validated['total_amount'] = $validated['amount'] -  $validated['discount_fixed'];

        $order = Order::create($validated);
        $invoice->updateAmount();

        return response()->json(['order' => $order], 200);
    }

    /**
     * Update the specified resource in storage.
     * 
     */
    public function update(OrderUpdateRequest $request, $local_id)
    {
        if(!Auth::user()->authorized('update orders'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $order = Order::findLocal($local_id);

        $validated = $request->validated();

        $validated['total_amount'] = $order->amount - $validated['discount_fixed'];

        $order->update($validated);

        $order->invoice->updateAmount();
        
        return response()->json(['order' => $order], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($local_id)
    {
        if(!Auth::user()->authorized('delete orders'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $order = Order::findLocal($local_id);
        $order->delete();

        $invoice = $order->invoice;
        $invoice->updateAmount();

        return response()->json(['order' => $order], 200);
    }
}
