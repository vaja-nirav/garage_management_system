<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceJobCardItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_job_card_id',
        'product_id',
        'quantity',
        'unit_price',
        'total',
    ];

    public function jobCard()
    {
        return $this->belongsTo(ServiceJobCard::class, 'service_job_card_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
