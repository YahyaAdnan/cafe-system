<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];
    
    public function items()
    {
        return $this->hasMany(Item::class);
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
