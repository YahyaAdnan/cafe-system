<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'paid',
        'remaining',
        'payment_method_id',
        'user_id',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->user_id = Auth::id();
            $model->remaining = $model->paid - $model->amount;
        });

        static::created(function ($model) {
            $transaction = Transaction::create([
                'amount' => $model->amount,
                'user_id' => Auth::id(),
                'payment_method_id' => $model->payment_method_id,
                'transactionable_type' => 'App\Models\Transaction',
                'transactionable_id' => $model->id,
            ]);

            $model->invoice->updateAmount();
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
