<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\DailySale;

class GenerateDailySale
{
    public static function createDailySale()
    {
        if(DailySale::where('active', true)->exists())
        {
            $old_daily_sale = DailySale::where('active', true)->first();
            $old_daily_sale->update([
                'active' => false
            ]);
        }

        $today = DailySale::where('title', 'like', date('Y-m-d') . '%');
        $title = $today->exists() ? 
            date('Y-m-d') . ' (' . ($today->count() + 1) . ')'
        : date('Y-m-d');

        return DailySale::create([
            'title' => $title
        ]);
    }

    public static function getInvoice(Invoice $invoice)
    {
        if(!DailySale::where('active', true)->exists())
        {
            GenerateDailySale::createDailySale();
        }

        $daily_sale = DailySale::where('active', true)->first();

        $daily_sale->invoices()->attach($invoice->id);
    }

}