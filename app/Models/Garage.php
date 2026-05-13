<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name',
        'garage_name',
        'slug',
        'email',
        'phone',
        'alternate_phone',
        'website',
        'logo',
        'cover_image',
        'description',
        'gst_number',
        'pan_number',
        'business_type',
        'established_year',
        'employee_count',
        'status',
    ];
}
