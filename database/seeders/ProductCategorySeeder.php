<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Garage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $garages = Garage::all();

        if ($garages->isEmpty()) {
            return;
        }

        $categories = [
            [
                'name' => 'Lubricants & Fluids',
                'description' => 'Engine oils, brake fluids, coolants, and transmission fluids.',
            ],
            [
                'name' => 'Filters',
                'description' => 'Oil filters, air filters, cabin filters, and fuel filters.',
            ],
            [
                'name' => 'Braking System',
                'description' => 'Brake pads, discs, drums, and shoes.',
            ],
            [
                'name' => 'Electrical Components',
                'description' => 'Batteries, spark plugs, alternators, and starter motors.',
            ],
            [
                'name' => 'Suspension & Steering',
                'description' => 'Shock absorbers, struts, control arms, and tie rod ends.',
            ],
            [
                'name' => 'Engine Parts',
                'description' => 'Timing belts, gaskets, valves, and water pumps.',
            ],
            [
                'name' => 'Tires & Wheels',
                'description' => 'All-season tires, alloy wheels, and wheel balancing weights.',
            ],
            [
                'name' => 'Car Care & Accessories',
                'description' => 'Wiper blades, car wash, wax, and interior cleaners.',
            ],
        ];

        foreach ($garages as $garage) {
            foreach ($categories as $category) {
                ProductCategory::updateOrCreate(
                    [
                        'garage_id' => $garage->id,
                        'name' => $category['name'],
                    ],
                    [
                        'slug' => Str::slug($category['name']) . '-' . $garage->id,
                        'description' => $category['description'],
                        'status' => true,
                    ]
                );
            }
        }
    }
}
