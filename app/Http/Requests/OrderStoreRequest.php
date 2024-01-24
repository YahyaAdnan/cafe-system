<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
        $total_amount = $this->input('quantity') * $this->input('amount');
        
        return [
            'quantity' => 'required|numeric|min:1',
            'local_invoice' => 'required|exists:invoices,local_id',
            'local_id' => 'nullable|numeric|min:0',
            'title' => 'required|min:3',
            'item_id' => 'nullable|exists:items,id',
            'price_id' => 'nullable|exists:prices,id',
            'amount' => 'required|min:0',
            'discount_fixed' => "required|min:0|max:$total_amount",
            'note' => 'nullable|max:255',
        ];
    }
}
