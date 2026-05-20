<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToGarage;

class Sale extends Model
{
    use HasFactory, BelongsToGarage;

    protected $fillable = [
        'garage_id',
        'customer_id',
        'service_job_card_id',
        'sale_number',
        'sale_date',
        'total_amount',
        'discount',
        'tax',
        'net_amount',
        'paid_amount',
        'payment_status',
        'notes',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function jobCard()
    {
        return $this->belongsTo(ServiceJobCard::class, 'service_job_card_id');
    }
}
