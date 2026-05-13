<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'garage_id' => 'required|exists:garages,id',
            'employee_code' => 'required|unique:staff,employee_code,' . $this->route('staff')->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'designation' => 'required|string',
            'basic_salary' => 'nullable|numeric|min:0',
            'status' => 'boolean',
        ];
    }
}
