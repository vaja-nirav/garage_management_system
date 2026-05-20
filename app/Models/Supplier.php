<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToGarage;

class Supplier extends Model
{
    use HasFactory, BelongsToGarage;

    protected $fillable = [
        'garage_id',
        'supplier_code',
        'company_name',
        'contact_person',
        'email',
        'phone',
        'gst_number',
        'address',
        'city',
        'state',
        'country',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
