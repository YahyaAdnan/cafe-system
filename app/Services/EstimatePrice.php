<?php
namespace App\Services;

use App\Models\Price;
use App\Models\Extra;
use App\Models\Item;

class EstimatePrice
{
    // Parameters: discount, amount, price_id, extras, quantity.
    // Discount: Nullable.
    // price_id: Nullable.
    // amount: Nullable.
    // quantity: Nullable.
    // extras: Array.
    public static function run($data)
    {
        $result = 0;

        $discount = isset($data['discount'])
            ? $data['discount']
            : 0 ;

        try {

            if (isset($data['price_id']))
            {
                $result += Price::find($data['price_id'])->amount;
            }
    
            if (isset($data['amount']))
            {
                $result += $data['amount'];
            }
    
            if (isset($data['extras']) && is_array($data['extras']))
            {
                $extras = Extra::whereIn('id', $data['extras'])->get();
    
                foreach ($extras as $key => $extra) 
                {
                    $result += $extra->amount;
                }
            }
    
            if (isset($data['discount']))
            {
                $result = max($result - $data['discount'], 0);
            }

            if (isset($data['quantity']))
            {
                $result *= $data['quantity'];
            }

        } catch (\Throwable $th) {}

        return $result;
    }
}