<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\OrdersExist;

class InvoiceSeperateRequest extends FormRequest
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
            "orders" => ['required', 'json', new OrdersExist],
            'local_invoice' => 'required|exists:invoices,local_id',
            'new_local_invoice' => 'required|numeric',
        ];
    }
}
