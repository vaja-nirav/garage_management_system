<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToGarage;

class VehicleInspection extends Model
{
    use HasFactory, BelongsToGarage;

    protected $fillable = [
        'garage_id',
        'service_job_card_id',
        'vehicle_id',
        'inspection_checklist_id',
        'status',
        'notes',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function serviceJobCard()
    {
        return $this->belongsTo(ServiceJobCard::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function checklist()
    {
        return $this->belongsTo(InspectionChecklist::class, 'inspection_checklist_id');
    }

    public function results()
    {
        return $this->hasMany(VehicleInspectionItem::class);
    }
}
