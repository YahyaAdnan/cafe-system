<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 
        'active', 
        'title', 
        'title_ar', 
        'title_ku', 
    ];

    public function offerEntities()
    {
        return $this->hasMany(OfferEntity::class);
    }
}
