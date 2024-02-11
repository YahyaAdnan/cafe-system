<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class InventoryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
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
                $inventory = Inventory::find($model->inventory_id);
                $inventory->update([
                    'quantity' => $inventory->quantity + $model->quantity
                ]);
            }
            else
            {
                $inventory = Inventory::find($model->inventory_id);
                $quantity = $inventory->quantity - $model->quantity;
                $inventory->update([
                    'quantity' => $quantity > 0 ? $quantity : 0
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

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
