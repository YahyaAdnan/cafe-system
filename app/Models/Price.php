<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'title',
        'amount',
        'note',
    ];

    
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $itemIngredients = $model->item->itemIngredients;

            foreach ($itemIngredients as $key => $itemIngredient)
            {
                IngredientDetails::create([
                    'item_ingredients_id' => $itemIngredient->id,
                    'ingredient_id' => $itemIngredient->ingredient_id,
                    'price_id' => $model->id,
                    'amount' => 0,
                ]);
            }
        });
    }

    public static function activePrices()
    {
        $all_prices = Price::all();
        $prices = array();
        foreach ($all_prices as $key => $price) 
        {
            $prices[$price->id] = $price->item->title . ' (' . $price->title . ' ' . $price->amount . 'IQD)';
        }
        return $prices;
    }

    public function validateIngredient()
    {
        foreach ($this->ingredientDetails as $key => $ingredient) 
        {
            if($ingredient->amount == '0')
            {
                return 0;
            }
        }
        return true;
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function offerEntities()
    {
        return $this->belongsToMany(OfferEntity::class, 'offer_entities_prices', 'price_id', 'offer_entity_id');
    }

    public function ingredientDetails()
    {
        return $this->hasMany(IngredientDetails::class, 'price_id');
    }
}
