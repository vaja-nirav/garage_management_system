<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleStatsIo\LaravelClient\Contracts\TrackablePayment;
use SimpleStatsIo\LaravelClient\Contracts\TrackablePerson;
use Carbon\CarbonInterface;

class Subscription extends Model implements TrackablePayment
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

    /**
     * Required by SimpleStats: Define who made the subscription payment.
     */
    public function getTrackingPerson(): TrackablePerson
    {
        // Get the first user associated with this garage (usually the owner/admin)
        return $this->garage->users()->first() ?? new User();
    }

    /**
     * Required by SimpleStats: Define the gross paid amount in cents.
     */
    public function getTrackingGross(): float
    {
        return (float) ($this->amount * 100);
    }

    /**
     * Required by SimpleStats: Define the net paid amount in cents.
     */
    public function getTrackingNet(): float
    {
        return (float) ($this->amount * 100);
    }

    /**
     * Required by SimpleStats: Define the ISO-4217 currency code.
     */
    public function getTrackingCurrency(): string
    {
        return 'USD';
    }

    /**
     * Required by SimpleStats: Tell the package when the subscription payment occurred.
     */
    public function getTrackingTime(): CarbonInterface
    {
        return $this->created_at;
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
