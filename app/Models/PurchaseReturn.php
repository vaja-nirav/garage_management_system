<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'purchase_id',
        'return_number',
        'return_date',
        'amount',
        'notes',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
