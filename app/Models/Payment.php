<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'paymentable_id',
        'paymentable_type',
        'payment_date',
        'amount',
        'payment_method',
        'payment_reference',
        'notes',
    ];

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
