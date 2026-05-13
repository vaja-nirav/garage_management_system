<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'name',
        'slug',
        'description',
        'status',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
