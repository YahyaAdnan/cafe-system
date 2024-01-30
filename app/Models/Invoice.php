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

    public static function findLocal($local_id)
    {
        return Invoice::where('local_id', $local_id)->latest()->first();
    }
    
    public function updateAmount()
    {
        $amount = $this->orders->pluck('total_amount')->sum();
        $paid = $this->payments->pluck('amount')->sum();

        if($this->discount_rate)
        {
            $amount = $amount * ((100 - $this->discount_rate) / 100);
        }

        if($this->discount_fixed)
        {
            $amount = $amount - $this->discount_fixed;
        }

        $taxes = $amount * ((100 + Setting::getTaxes()) / 100) - $amount;
        $services = $amount * ((100 + Setting::getServices()) / 100) - $amount ;

        $total_amount = $amount + $taxes + $services;

        $this->update([
            'amount' => $total_amount,
            'remaining' => $total_amount - $paid,
        ]);
    }

    public function invoices()
    {
        return $this->belongsToMany(DailySale::class, 'daily_sale_invoices', 'invoice_id', 'daily_sale_id');
    }

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
