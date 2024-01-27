<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySale extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'active'
    ];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'daily_sale_invoices', 'daily_sale_id', 'invoice_id');
    }
}
