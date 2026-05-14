<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic Plan',
                'slug' => 'basic-plan',
                'description' => 'Perfect for small garages starting their digital journey.',
                'monthly_price' => 29.00,
                'yearly_price' => 290.00,
                'trial_days' => 14,
                'max_staff' => 3,
                'max_customers' => 100,
                'max_vehicles' => 150,
                'max_products' => 200,
            ],
            [
                'name' => 'Standard Plan',
                'slug' => 'standard-plan',
                'description' => 'Ideal for growing garages with multiple staff members.',
                'monthly_price' => 59.00,
                'yearly_price' => 590.00,
                'trial_days' => 14,
                'max_staff' => 10,
                'max_customers' => 500,
                'max_vehicles' => 750,
                'max_products' => 1000,
            ],
            [
                'name' => 'Premium Plan',
                'slug' => 'premium-plan',
                'description' => 'Unlimited power for professional garage chains.',
                'monthly_price' => 99.00,
                'yearly_price' => 990.00,
                'trial_days' => 30,
                'max_staff' => 50,
                'max_customers' => 5000,
                'max_vehicles' => 7500,
                'max_products' => 10000,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
