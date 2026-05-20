<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToGarage;

class Quotation extends Model
{
    use HasFactory, BelongsToGarage;

    protected $fillable = [
        'garage_id',
        'customer_id',
        'vehicle_id',
        'quotation_number',
        'quotation_date',
        'valid_until',
        'total_amount',
        'tax_amount',
        'net_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'quotation_date' => 'date',
        'valid_until' => 'date',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }
}
