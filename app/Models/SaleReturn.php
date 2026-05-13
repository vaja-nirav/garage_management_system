<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'sale_id',
        'return_number',
        'return_date',
        'amount',
        'notes',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
