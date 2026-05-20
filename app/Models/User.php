<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use SimpleStatsIo\LaravelClient\Contracts\TrackablePerson;
use Carbon\CarbonInterface;

#[Fillable(['name', 'email', 'password', 'garage_id', 'image', 'status', 'phone', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements TrackablePerson
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Return the creation date for tracking registration.
     */
    public function getTrackingTime(): CarbonInterface
    {
        return $this->created_at ?? now();
    }

    /**
     * Get the garage that the user belongs to.
     */
    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
