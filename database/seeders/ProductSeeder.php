<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Garage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $garages = Garage::all();

        foreach ($garages as $garage) {
            $categories = ProductCategory::where('garage_id', $garage->id)->get();

            if ($categories->isEmpty()) {
                continue;
            }

            $productsData = [
                'Lubricants & Fluids' => [
                    ['name' => 'Engine Oil 5W-30 (4L)', 'price' => 45.00, 'purchase' => 30.00],
                    ['name' => 'Synthetic Motor Oil 0W-40', 'price' => 65.00, 'purchase' => 45.00],
                    ['name' => 'Brake Fluid DOT 4 (500ml)', 'price' => 12.00, 'purchase' => 7.00],
                    ['name' => 'Radiator Coolant (5L)', 'price' => 25.00, 'purchase' => 15.00],
                ],
                'Filters' => [
                    ['name' => 'Oil Filter (Standard)', 'price' => 15.00, 'purchase' => 8.00],
                    ['name' => 'Air Filter (Premium)', 'price' => 22.00, 'purchase' => 12.00],
                    ['name' => 'Cabin AC Filter', 'price' => 18.00, 'purchase' => 10.00],
                    ['name' => 'Fuel Filter (Diesel)', 'price' => 35.00, 'purchase' => 20.00],
                ],
                'Braking System' => [
                    ['name' => 'Front Brake Pads Set', 'price' => 85.00, 'purchase' => 50.00],
                    ['name' => 'Rear Brake Shoes', 'price' => 60.00, 'purchase' => 35.00],
                    ['name' => 'Brake Disc (Pair)', 'price' => 120.00, 'purchase' => 80.00],
                ],
                'Electrical Components' => [
                    ['name' => '12V Lead Acid Battery (65Ah)', 'price' => 110.00, 'purchase' => 75.00],
                    ['name' => 'Spark Plug (Iridium)', 'price' => 12.00, 'purchase' => 6.00],
                    ['name' => 'H7 Halogen Bulb', 'price' => 8.00, 'purchase' => 3.00],
                ],
                'Car Care & Accessories' => [
                    ['name' => 'Wiper Blade Set (24"/18")', 'price' => 25.00, 'purchase' => 12.00],
                    ['name' => 'Microfiber Cleaning Cloth', 'price' => 5.00, 'purchase' => 2.00],
                    ['name' => 'Car Shampoo (1L)', 'price' => 10.00, 'purchase' => 5.00],
                ],
            ];

            foreach ($productsData as $catName => $products) {
                $category = $categories->where('name', $catName)->first();
                if (!$category) continue;

                foreach ($products as $p) {
                    Product::updateOrCreate(
                        [
                            'garage_id' => $garage->id,
                            'name' => $p['name'],
                        ],
                        [
                            'product_category_id' => $category->id,
                            'sku' => strtoupper(substr($catName, 0, 3)) . '-' . rand(1000, 9999),
                            'slug' => Str::slug($p['name']) . '-' . $garage->id,
                            'product_type' => 'physical',
                            'description' => 'High quality ' . $p['name'] . ' for professional use.',
                            'purchase_price' => $p['purchase'],
                            'selling_price' => $p['price'],
                            'min_stock_alert' => 5,
                            'is_service_part' => true,
                            'track_stock' => true,
                            'status' => true,
                        ]
                    );
                }
            }
        }
    }
}
