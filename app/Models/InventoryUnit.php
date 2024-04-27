<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];
    

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function isDeletable()
    {
        if($this->inventories->isNotEmpty())
        {
            return false;
        }

        return true;
    }
}
