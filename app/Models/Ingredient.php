<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_available',
    ];
    
    public function itemIngredient()
    {
        return $this->hasMany(ItemIngredient::class);
    }

    public function isDeletable()
    {
        if($this->itemIngredient->isNotEmpty())
        {
            return false;
        }

        return true;
    }
}
