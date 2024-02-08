<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'image',
        'is_available',
        'show',
        'show_ingredients',
        'item_type_id',
        'item_category_id',
        'item_subcategory_id',
        'note',
    ];
    
    public function itemCategory()
    {
        return $this->belongsTo(ItemCategory::class);
    }

    public function extras()
    {
        return $this->belongsToMany(Extra::class, 'extra_items', 'item_id', 'extra_id');
    }

    public function itemSubcategory()
    {
        return $this->belongsTo(ItemSubcategory::class);
    }

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function itemIngredients()
    {
        return $this->hasMany(ItemIngredient::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

}
