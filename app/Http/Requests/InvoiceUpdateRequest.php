<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
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
            'title' => 'required|min:1|max:32',
            'table_id' => 'nullable|exists:tables,id',
            'employee_id' => 'nullable|exists:employees,id',
            'deliver_type_id' => 'nullable|exists:deliver_types,id',
            'discount_rate' => 'required|numeric|min:0|max:100',
            'discount_fixed' => 'required|numeric|min:0',
            'note' => 'nullable|max:255',
        ];
    }
}
