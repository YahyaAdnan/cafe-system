<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'title',
        'item_id',
        'price_id',
        'user_id',
        'amount',
        'discount_fixed',
        'total_amount',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($model) {
            $model->invoice->updateAmount();
        });

        static::updating(function ($model) {
            $model->total_amount = $model->amount - $model->discount_fixed;
        });

        static::updated(function ($model) {
            $model->invoice->updateAmount();
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
  
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
