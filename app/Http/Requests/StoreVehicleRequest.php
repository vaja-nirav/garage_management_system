<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
            'vehicle_code' => 'required|unique:vehicles,vehicle_code',
            'registration_number' => 'required|unique:vehicles,registration_number',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'nullable|integer',
            'color' => 'nullable|string',
        ];
    }
}
