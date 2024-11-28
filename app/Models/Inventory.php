<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'quantity',
        'inventory_unit_id',
        'ingredient_id',
        'user_id',
        'note'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) 
        {
            $model->user_id = Auth::id();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventoryUnit()
    {
        return $this->belongsTo(InventoryUnit::class);
    }
}
