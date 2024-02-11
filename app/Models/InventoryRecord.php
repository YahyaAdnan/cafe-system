<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'inventory_id',
        'supplier_id',
        'expense_id',
        'quantity',
        'user_id',
        'type'
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
