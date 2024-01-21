<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'inovice_no',
        'title',
        'local_id',
        'active',
        'dinning_in',
        'table_id',
        'amount',
        'remaining',
        'discount_rate',
        'discount_fixed',
        'note',
    ];
    
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
