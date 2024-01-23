<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\InvoiceAmount;

class PaymentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'local_id' => 'required|exists:invoices,local_id',
            'amount' => ['required', 'numeric', 'min:0', new InvoiceAmount($this->input('local_id'))],
            'paid' => "required|numeric|min:{$this->input('amount')}",
            'payment_method_id' => 'required|exists:payment_methods,id',
            'note' => 'nullable|max:255',
        ];
    }
}
