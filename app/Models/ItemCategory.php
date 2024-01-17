<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_type_id',
        'title',
        'title_ar',
        'title_ku',
        'image'
    ];
    
    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function itemSubcategories()
    {
        return $this->hasMany(ItemSubcategory::class);
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
