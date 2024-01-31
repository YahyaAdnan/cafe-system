<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Order;

class OrdersExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $orders = json_decode($value);

        foreach ($orders as $key => $order) 
        {
            if(Order::findLocal($order) == null)
            {
                $fail("One of the orders id doesn't exist.");
            }
        }
    }
}
