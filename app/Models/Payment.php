<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToGarage;
use SimpleStatsIo\LaravelClient\Contracts\TrackablePayment;
use SimpleStatsIo\LaravelClient\Contracts\TrackablePerson;
use Carbon\CarbonInterface;

class Payment extends Model implements TrackablePayment
{
    use HasFactory, BelongsToGarage;

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

    /**
     * Required by SimpleStats: Define who made/is associated with the payment.
     */
    public function getTrackingPerson(): TrackablePerson
    {
        // Get the first user associated with this garage (usually the owner/admin)
        return $this->garage ? ($this->garage->users()->first() ?? new User()) : new User();
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
        return 'INR';
    }

    /**
     * Required by SimpleStats: Tell the package when the payment occurred.
     */
    public function getTrackingTime(): CarbonInterface
    {
        return $this->created_at ?? now();
    }

    public function paymentable()
    {
        return $this->morphTo();
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
