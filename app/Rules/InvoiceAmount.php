<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Invoice;

class InvoiceAmount implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $local_id;

    public function __construct($local_id = null)
    {
        $this->local_id = $local_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $invoice = Invoice::where('local_id', $this->local_id)->latest()->first();

        if($invoice->remaining < $value)
        {
            $fail("The paid amount must be less then {$invoice->remaining}");
        }
    }
}
