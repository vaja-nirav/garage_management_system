<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'garage_id' => 'required|exists:garages,id',
            'expense_number' => 'required|unique:expenses,expense_number',
            'expense_category' => 'required|string',
            'expense_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
