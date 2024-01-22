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
    protected $invoice_id;

    public function __construct($invoice_id = null)
    {
        $this->invoice_id = $invoice_id;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $invoice = Invoice::find($this->invoice_id);

        if($invoice->remaining < $value)
        {
            $fail("The paid amount must be less then {$invoice->remaining}");
        }
    }
}
