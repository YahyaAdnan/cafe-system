<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_ar',
        'title_ku',
        'is_available',
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ingredient) {
            
        });
    }

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
