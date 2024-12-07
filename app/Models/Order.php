<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\EstimatePrice;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'title',
        'title_ar',
        'title_ku',
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
            $model->restockIngredients();
        });

        static::creating(function ($model) {
            $model->title_ar = $model->item_id ? Item::find($model->item_id)->title_ar : $model->title;
            $model->title_ku = $model->item_id ? Item::find($model->item_id)->title_ku : $model->title;
        });

        static::created(function ($model) {
            $model->invoice->updateAmount();
            $model->consumeIngredients();
        });

        static::updating(function ($model) {
            $model->total_amount = $model->getTotal();
        });

        static::updated(function ($model) {
            $model->invoice->updateAmount();
        });
    }

    public function getTotal()
    {
        return EstimatePrice::run([
            'discount' => $this->discount_fixed,
            'amount' => $this->amount,
            'extras' => $this->extras->pluck('id')->toArray(),
        ]);
    }

    public function setTotal()
    {
        $this->total_amount = $this->getTotal();
        $this->save();
    }

    public function consumeIngredients()
    {
        if(!$this->price_id)
        {
            return;
        }

        $ingredients = $this->price->ingredientDetails;
        
        foreach ($ingredients as $key => $ingredient) 
        {
            $ingredient->consume();
        }
    }

    public function restockIngredients()
    {
        if(!$this->price_id)
        {
            return;
        }

        $ingredients = $this->price->ingredientDetails;
        foreach ($ingredients as $key => $ingredient) 
        {
            $ingredient->restock();
        }
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
  
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'order_extras', 'order_id', 'extra_id');
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
