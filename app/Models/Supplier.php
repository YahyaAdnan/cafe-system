<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function inventoryRecord()
    {
        return $this->belongsTo(InventoryRecord::class);
    }
}
