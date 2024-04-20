<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'note'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'extra_items', 'extra_id', 'item_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_extras', 'extra_id', 'order_id');
    }

    public function isDeletable()
    {
        if($this->items->isNotEmpty())
        {
            return false;
        }

        return true;
    }

}
