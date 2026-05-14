<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceJobCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'customer_id',
        'vehicle_id',
        'staff_id',
        'job_card_number',
        'in_date',
        'out_date',
        'estimated_cost',
        'actual_cost',
        'status',
        'customer_complaints',
        'work_done',
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

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'service_job_card_id');
    }

    public function items()
    {
        return $this->hasMany(ServiceJobCardItem::class, 'service_job_card_id');
    }
}
