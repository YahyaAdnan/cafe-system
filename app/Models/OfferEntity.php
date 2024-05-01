<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferEntity extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'price',
        'show',
        'active'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->prices()->delete(); 
        });
    }

    // Rebuild prices
    public function setPrices()
    {
        // just delete all prices related to offers.
        $this->prices()->delete();

        if (!$this->active)
        {
            return;
        
        }

        foreach ($this->items as $key => $item)
        {
            // TO-DO: MAKE EACH ENTITY HAVE IT's OWN TITLE.
            $price = Price::create([
                'item_id' => $item->id,
                'title' => $this->offer->title,
                'amount' => $this->price,
            ]);

            $this->prices()->attach($price);
        }

        return $this->belongsTo(Offer::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'offer_entities_items', 'offer_entity_id', 'item_id');
    }

    public function prices()
    {
        return $this->belongsToMany(Price::class, 'offer_entities_prices', 'offer_entity_id', 'price_id');
    }
}
