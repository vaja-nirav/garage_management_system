<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'key',
        'value',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
