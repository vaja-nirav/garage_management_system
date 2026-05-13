<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'plan_id',
        'billing_cycle',
        'amount',
        'starts_at',
        'expires_at',
        'trial_ends_at',
        'status',
        'payment_gateway',
        'auto_renew',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
            'trial_ends_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'auto_renew' => 'boolean',
        ];
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
