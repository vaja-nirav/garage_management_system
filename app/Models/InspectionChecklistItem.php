<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspection_checklist_id',
        'item_name',
        'category',
        'sort_order',
    ];

    public function checklist()
    {
        return $this->belongsTo(InspectionChecklist::class, 'inspection_checklist_id');
    }
}
