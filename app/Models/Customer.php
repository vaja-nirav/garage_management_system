<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'garage_id',
        'customer_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'alternate_phone',
        'gender',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'profile_photo',
        'wallet_balance',
        'total_visits',
        'total_spent',
        'customer_type',
        'membership_status',
        'status',
        'last_visit_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'last_visit_at' => 'datetime',
        ];
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
