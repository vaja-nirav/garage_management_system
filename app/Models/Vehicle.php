<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'customer_id',
        'vehicle_code',
        'registration_number',
        'chassis_number',
        'engine_number',
        'make',
        'model',
        'year',
        'variant',
        'fuel_type',
        'transmission',
        'mileage',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
