<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'product_category_id',
        'sku',
        'barcode',
        'name',
        'slug',
        'product_type',
        'description',
        'purchase_price',
        'selling_price',
        'quantity',
        'min_stock_alert',
        'tax_rate',
        'image',
        'is_service_part',
        'track_stock',
        'status',
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
