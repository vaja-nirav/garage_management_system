<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToGarage;

class InspectionChecklist extends Model
{
    use HasFactory, BelongsToGarage;

    protected $fillable = [
        'garage_id',
        'name',
        'description',
        'is_active',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function items()
    {
        return $this->hasMany(InspectionChecklistItem::class)->orderBy('sort_order');
    }
}
