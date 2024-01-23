<?php

namespace App\Http\Controllers\Api;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd('hey');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request)
    {
        if(!Auth::user()->authorized('create payments'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $invoice = Invoice::where('local_id', $request->local_id)->latest()->first();

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'paid' => $request->paid,
            'remaining' => $request->paid - $request->amount,
            'payment_method_id' => $request->payment_method_id,
            'user_id' => Auth::id(),
        ]);
        
        $invoice->update([
            'remaining' => $invoice->remaining - $request->amount
        ]);

        $transactions = Transaction::create([
            'amount' => $request->amount,
            'user_id' => Auth::id(),
            'payment_method_id' => $request->payment_method_id,
            'transactionable_type' => "App\Models\Payment",
            'transactionable_id' => $payment->id,
        ]);

        return response()->json(['invoice' => $invoice], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
