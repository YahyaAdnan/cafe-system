<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'is_available',
        'inventory_unit_id',
        'quantity'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($ingredient) 
        {
            $ingredient->is_available = $ingredient->quantity > 0;
        });
    }

    public function itemIngredient()
    {
        return $this->hasMany(ItemIngredient::class);
    }

    public function ingredientDetails()
    {
        return $this->hasMany(IngredientDetails::class, 'ingredient_id');
    }

    public function inventoryRecords()
    {
        return $this->hasMany(InventoryRecord::class);
    }


    public function inventoryUnit()
    {
        return $this->belongsTo(InventoryUnit::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function isDeletable()
    {
        if($this->itemIngredient->isNotEmpty())
        {
            return false;
        }

        return true;
    }
}
