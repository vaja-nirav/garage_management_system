<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\ServiceJobCard;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'garage_id',
        'customer_id',
        'vehicle_code',
        'registration_number',
        'chassis_number',
        'engine_number',
        'make',
        'model',
        'year',
        'variant',
        'fuel_type',
        'transmission',
        'mileage',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function jobCards()
    {
        return $this->hasMany(ServiceJobCard::class);
    }

    /**
     * Get all products used on this vehicle across all job cards.
     */
    public function usedProducts()
    {
        $jobCardIds = $this->jobCards()->pluck('id')->toArray();

        return Product::whereIn('id', function (Builder $query) use ($jobCardIds) {
            $query->select('product_id')
                ->from('sale_items')
                ->whereIn('sale_id', function (Builder $subQuery) use ($jobCardIds) {
                    $subQuery->select('id')
                        ->from('sales')
                        ->whereIn('service_job_card_id', $jobCardIds);
                });
        })->get();
    }
}
