<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'garage_id' => 'required|exists:garages,id',
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'staff_id' => 'nullable|exists:staff,id',
            'job_card_number' => 'required|unique:service_job_cards,job_card_number',
            'estimated_cost' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,ongoing,completed,delivered',
            'customer_complaints' => 'nullable|string',
        ];
    }
}
