<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'expense_category',
        'expense_number',
        'expense_date',
        'amount',
        'notes',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }
}
