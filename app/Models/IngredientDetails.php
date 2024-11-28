<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IngredientDetails extends Model
{
    use HasFactory;
    // Specify the table name if it does not follow the Laravel convention
    protected $table = 'ingredient_details';

    // Specify the fillable attributes
    protected $fillable = [
        'item_ingredients_id',
        'ingredient_id',
        'price_id',
        'amount',
    ];

    public function consume()
    {
        if($this->ingredient->inventories->isEmpty())
        {
            return;
        }

        $inventory = $this->ingredient->inventories->first();

        $inventory->quantity = max(0, $inventory->quantity - $this->amount);
        $inventory->save();
    }

    public function restock()
    {
        if($this->ingredient->inventories->isEmpty())
        {
            return;
        }

        $inventory = $this->ingredient->inventories->first();

        $inventory->quantity += $this->amount;
        $inventory->save();
    }

    // Define the relationship with the Ingredient model
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_id');
    }

    // Define the relationship with the Ingredient model
    public function itemIngredients()
    {
        return $this->belongsTo(ItemIngredient::class, 'item_ingredients_id');
    }

    // Define the relationship with the Price model
    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id');
    }
}
