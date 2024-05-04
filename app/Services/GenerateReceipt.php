<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class GenerateReceipt
{
    // Parameters -> $data : array
    // $data -> must contains lang (title, title_ar, title_ku), and $invoice (TO-DO: THIS WILL BE MODIFIED BY YAHYA LATER.)
    // So when you call function it must be lile: GenerateReceipt::generate(['lang' => 'title_ar', 'invoice' => $this->model])
    public static function generate($data)
    {
        $result = [];

        // GROUP BY PRICE, TITle with the quantity.
        $result['orders'] = DB::table('orders')
            ->where('invoice_id', $data['invoice']->id)
            ->select($data['lang'], 'total_amount', 'price_id', DB::raw('COUNT(*) as count'))
            ->groupBy($data['lang'], 'total_amount', 'price_id')
            ->get()
            ->toArray();
        
        $result['total'] = array();

        // If they have taxes it must be shown in receipt.
        if(Setting::getTaxes() != 0)
        {
            $result['total']['tax'] = Setting::getTaxes();
        }

        // If they have services it must be shown in receipt.
        if(Setting::getServices() != 0)
        {
            $result['total']['srv'] = Setting::getServices();
        }

        $result['total']['amount'] = $data['invoice']->amount;
        $result['total']['discount_rate'] = $data['invoice']->discount_rate;
        $result['total']['discount_fixed'] = $data['invoice']->discount_fixed;

        dd($result);
    }
}