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
     * Store a newly created resource in storage.
     */
    public function store(PaymentStoreRequest $request)
    {
        if(!Auth::user()->authorized('create payments'))
        {
            return response()->json(['errors' => 'Not Authorized.'], 403);
        }

        $invoice = Invoice::findLocal($request->local_id);

        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $request->amount,
            'paid' => $request->paid,
            'remaining' => $request->paid - $request->amount,
            'payment_method_id' => $request->payment_method_id,
            'user_id' => Auth::id(),
        ]);

        $invoice->updateAmount();
        
        $transactions = Transaction::create([
            'amount' => $request->amount,
            'user_id' => Auth::id(),
            'payment_method_id' => $request->payment_method_id,
            'transactionable_type' => "App\Models\Payment",
            'transactionable_id' => $payment->id,
        ]);

        return response()->json(['invoice' => $invoice], 200);
    }
}
