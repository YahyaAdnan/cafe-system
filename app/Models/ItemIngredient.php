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
    
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
