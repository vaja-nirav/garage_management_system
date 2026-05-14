<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Garage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
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

        $customers = [
            [
                'first_name' => 'Amit',
                'last_name' => 'Patel',
                'email' => 'amit.patel@example.com',
                'phone' => '9988776655',
                'gender' => 'male',
                'address' => 'A-101, Rivera Heights',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'country' => 'India',
                'zip_code' => '380015',
                'customer_type' => 'regular',
                'membership_status' => 'Gold',
            ],
            [
                'first_name' => 'Priya',
                'last_name' => 'Sharma',
                'email' => 'priya.sharma@example.com',
                'phone' => '9988776656',
                'gender' => 'female',
                'address' => 'B-202, Skyline Residency',
                'city' => 'Surat',
                'state' => 'Gujarat',
                'country' => 'India',
                'zip_code' => '395007',
                'customer_type' => 'corporate',
                'membership_status' => 'Platinum',
            ],
            [
                'first_name' => 'Rajesh',
                'last_name' => 'Kumar',
                'email' => 'rajesh.kumar@example.com',
                'phone' => '9988776657',
                'gender' => 'male',
                'address' => 'C-303, Green View Park',
                'city' => 'Vadodara',
                'state' => 'Gujarat',
                'country' => 'India',
                'zip_code' => '390001',
                'customer_type' => 'regular',
                'membership_status' => 'Silver',
            ],
            [
                'first_name' => 'Sneha',
                'last_name' => 'Gupta',
                'email' => 'sneha.gupta@example.com',
                'phone' => '9988776658',
                'gender' => 'female',
                'address' => 'D-404, Ocean Breeze',
                'city' => 'Rajkot',
                'state' => 'Gujarat',
                'country' => 'India',
                'zip_code' => '360001',
                'customer_type' => 'regular',
                'membership_status' => null,
            ],
            [
                'first_name' => 'Vikram',
                'last_name' => 'Singh',
                'email' => 'vikram.singh@example.com',
                'phone' => '9988776659',
                'gender' => 'male',
                'address' => 'E-505, Mountain View',
                'city' => 'Bhavnagar',
                'state' => 'Gujarat',
                'country' => 'India',
                'zip_code' => '364001',
                'customer_type' => 'corporate',
                'membership_status' => 'Gold',
            ],
            [
                'first_name' => 'Anjali',
                'last_name' => 'Desai',
                'email' => 'anjali.desai@example.com',
                'phone' => '9988776660',
                'gender' => 'female',
                'address' => 'F-606, Gardenia Flats',
                'city' => 'Gandhinagar',
                'state' => 'Gujarat',
                'country' => 'India',
                'zip_code' => '382010',
                'customer_type' => 'regular',
                'membership_status' => 'Platinum',
            ],
            [
                'first_name' => 'Rohan',
                'last_name' => 'Mehta',
                'email' => 'rohan.mehta@example.com',
                'phone' => '9988776661',
                'gender' => 'male',
                'address' => 'G-707, Sapphire Towers',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'country' => 'India',
                'zip_code' => '380054',
                'customer_type' => 'regular',
                'membership_status' => 'Silver',
            ],
        ];

        foreach ($customers as $index => $customerData) {
            $garage = $garages->random();
            Customer::updateOrCreate(
                ['email' => $customerData['email']],
                array_merge($customerData, [
                    'garage_id' => $garage->id,
                    'customer_code' => 'CUST-' . strtoupper(Str::random(6)) . '-' . ($index + 1),
                    'wallet_balance' => rand(0, 5000),
                    'total_visits' => rand(1, 10),
                    'total_spent' => rand(1000, 50000),
                    'status' => true,
                    'last_visit_at' => now()->subDays(rand(1, 30)),
                ])
            );
        }
    }
}
