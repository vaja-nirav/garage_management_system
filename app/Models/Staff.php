<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToGarage;

class Staff extends Model
{
    use HasFactory, BelongsToGarage;

    protected $fillable = [
        'garage_id',
        'user_id',
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'designation',
        'gender',
        'dob',
        'joining_date',
        'department',
        'employment_type',
        'salary_type',
        'basic_salary',
        'profile_photo',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'joining_date' => 'date',
            'status' => 'boolean',
        ];
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
