<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\GenerateDailySale;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'inovice_no',
        'title',
        'active',
        'dinning_in',
        'table_id',
        'amount',
        'remaining',
        'discount_rate',
        'discount_fixed',
        'deliver_type_id',
        'employee_id',
        'note',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            GenerateDailySale::getInvoice($model);
        });
    }

    public function updateAmount()
    {
        $amount = $this->orders->pluck('total_amount')->sum();
        $paid = $this->payments->pluck('amount')->sum();
    
        if ($this->discount_rate) {
            $amount = $amount * ((100 - $this->discount_rate) / 100);
        }
    
        if ($this->discount_fixed) {
            $amount = max(0, $amount - $this->discount_fixed);
        }
    
        $taxes = max(0, $amount * ((100 + Setting::getTaxes()) / 100) - $amount);
        $services = max(0, $amount * ((100 + Setting::getServices()) / 100) - $amount);
    
        $total_amount = $amount + $taxes + $services;
        $remaining = max(0, $total_amount - $paid);

        $this->update([
            'amount' => $total_amount,
            'remaining' => $remaining,
        ]);
    }

    public function cancelInvoice()
    {
        $this->update([
            'active' => 0,
            'amount' => 0,
            'remaining' => 0,
        ]);
    }

    static public function fetchActive()
    {
        $invoices = array();

        foreach (Invoice::where('active', 1)->get() as $key => $invoice)
        {
            if($invoice->table_id)
            {
                $invoices[$invoice->id] = 'Table-' . $invoice->seating->title . ": #$invoice->title ($invoice->amount IQD)";
                continue;
            }
            $invoices[$invoice->id] = 'order-' . $invoice->deliverType->title . ": #$invoice->title ($invoice->amount IQD)";
        }

        return collect($invoices);
    }
    
    public function invoices()
    {
        return $this->belongsToMany(DailySale::class, 'daily_sale_invoices', 'invoice_id', 'daily_sale_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function seating()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    public function deliverType()
    {
        return $this->belongsTo(DeliverType::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
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
