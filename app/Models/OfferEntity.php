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
