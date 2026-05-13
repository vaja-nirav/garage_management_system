<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'garage_id' => 'required|exists:garages,id',
            'supplier_code' => 'required|unique:suppliers,supplier_code',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'gst_number' => 'nullable|string',
        ];
    }
}
