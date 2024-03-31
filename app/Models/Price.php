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

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
