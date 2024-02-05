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

    protected static function boot()
    {
        parent::boot();

        static::creating(function () 
        {
            if(DailySale::where('active', true)->exists())
            {
                $old_daily_sale = DailySale::where('active', true)->first();
                $old_daily_sale->update([
                    'active' => false
                ]);
            }
        });
    }


    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'daily_sale_invoices', 'daily_sale_id', 'invoice_id');
    }
}
