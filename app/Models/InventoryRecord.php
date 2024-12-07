<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'supplier_id',
        'expense_id',
        'quantity',
        'user_id',
        'type'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) 
        {
            $model->user_id = Auth::id();
        });

        static::created(function ($model) {
            if($model->type == "Increase")
            {
                $ingredient = Ingredient::find($model->ingredient_id);
                $ingredient->update([
                    'quantity' => $ingredient->quantity + $model->quantity
                ]);
            }
            else
            {
                $ingredient = Ingredient::find($model->ingredient_id);
                $quantity = $ingredient->quantity - $model->quantity;
                $ingredient->update([
                    'quantity' => max(0, $quantity)
                ]);
            }
        });
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
