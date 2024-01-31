<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Invoice;

class InvoicesExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $invoices = json_decode($value);

        foreach ($invoices as $key => $invoice) 
        {
            if(Invoice::findLocal($invoice) == null)
            {
                $fail("One of the invoices id doesn't exist.");
            }
        }
    }
}
