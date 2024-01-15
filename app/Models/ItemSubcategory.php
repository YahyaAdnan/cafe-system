<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'item_category_id',
    ];
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
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
