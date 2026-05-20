<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInspectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_inspection_id',
        'inspection_checklist_item_id',
        'status',
        'notes',
    ];

    public function inspection()
    {
        return $this->belongsTo(VehicleInspection::class, 'vehicle_inspection_id');
    }

    public function checklistItem()
    {
        return $this->belongsTo(InspectionChecklistItem::class, 'inspection_checklist_item_id');
    }
}
