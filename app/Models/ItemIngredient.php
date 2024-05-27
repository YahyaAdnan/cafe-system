<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemIngredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'ingredient_id',
        'main',
        'note',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $prices = $model->item->prices;

            foreach ($prices as $key => $price) 
            {
                IngredientDetails::create([
                    'item_ingredients_id' => $model->id,
                    'ingredient_id' => $model->ingredient_id,
                    'price_id' => $price->id,
                    'amount' => 0,
                ]);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }
}
