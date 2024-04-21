<?php
namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class DiscountService
{

    public static function maximumRateDiscount()
    {
        return Auth::user()->authorized('create discount')
            ? 100
            : Setting::get('Max Rate Discount');
    }

    public static function maximumFixedeDiscount()
    {
        return Auth::user()->authorized('create discount')
            ? 2000000000
            : Setting::get('Max Fixed Discount');
    }

    public static function maximumItemDiscount($amount)
    {
        $max = Auth::user()->authorized('create discount')
            ? 100
            : Setting::get('Max Item Discount');
        
        return min($amount, $max);
    }
}