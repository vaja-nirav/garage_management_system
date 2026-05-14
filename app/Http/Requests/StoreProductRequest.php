<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'garage_id' => 'required|exists:garages,id',
            'product_category_id' => 'nullable|exists:product_categories,id',
            'sku' => 'required|unique:products,sku',
            'name' => 'required|string|max:255',
            'product_type' => 'required|string|in:standard,service',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'min_stock_alert' => 'required|integer|min:0',
            'quantity' => 'nullable|integer|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'tax_type' => 'required|string|in:exclusive,inclusive',
            'hsn_code' => 'nullable|string|max:20',
            'barcode' => 'nullable|string|max:50',
        ];
    }
}
