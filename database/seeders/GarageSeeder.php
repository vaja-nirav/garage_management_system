<?php

namespace Database\Seeders;

use App\Models\Garage;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GarageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $garages = [
            [
                'garage_name' => 'Elite Auto Care',
                'owner_name' => 'John Doe',
                'slug' => 'elite-auto-care',
                'email' => 'contact@eliteautocare.com',
                'phone' => '9876543210',
                'alternate_phone' => '9876543220',
                'website' => 'https://eliteautocare.com',
                'gst_number' => '24AAAAA0000A1Z5',
                'pan_number' => 'ABCDE1234F',
                'description' => '123 Business Park, Main Street, Ahmedabad, Gujarat - 380001. Leading multi-brand car service center.',
                'business_type' => 'Multi-brand Service Center',
                'established_year' => '2015',
                'employee_count' => 15,
                'status' => true,
            ],
            [
                'garage_name' => 'Precision Motors',
                'owner_name' => 'Jane Smith',
                'slug' => 'precision-motors',
                'email' => 'info@precisionmotors.com',
                'phone' => '9876543211',
                'alternate_phone' => '9876543221',
                'website' => 'https://precisionmotors.com',
                'gst_number' => '24BBBBB1111B1Z5',
                'pan_number' => 'FGHIJ5678K',
                'description' => '456 Industrial Estate, S.G. Highway, Ahmedabad, Gujarat. Luxury car repair and maintenance specialist.',
                'business_type' => 'Luxury Car Specialist',
                'established_year' => '2018',
                'employee_count' => 8,
                'status' => true,
            ],
            [
                'garage_name' => 'Quick Fix Garage',
                'owner_name' => 'Mike Johnson',
                'slug' => 'quick-fix-garage',
                'email' => 'support@quickfix.com',
                'phone' => '9876543212',
                'alternate_phone' => null,
                'website' => 'https://quickfixgarage.in',
                'gst_number' => '24CCCCC2222C1Z5',
                'pan_number' => 'LMNOP9012M',
                'description' => 'Shop No. 12, City Center Mall, Surat, Gujarat. Quick oil change and general repairs.',
                'business_type' => 'General Workshop',
                'established_year' => '2020',
                'employee_count' => 5,
                'status' => true,
            ],
            [
                'garage_name' => 'Speedy Service Hub',
                'owner_name' => 'Sarah Williams',
                'slug' => 'speedy-service-hub',
                'email' => 'hello@speedyservice.com',
                'phone' => '9876543213',
                'alternate_phone' => '9876543223',
                'website' => null,
                'gst_number' => '24DDDDD3333D1Z5',
                'pan_number' => 'QRSTU3456P',
                'description' => 'Plot 78, GIDC Area, Vadodara, Gujarat. Authorized service center for multiple brands.',
                'business_type' => 'Quick Service Station',
                'established_year' => '2022',
                'employee_count' => 10,
                'status' => true,
            ],
            [
                'garage_name' => 'Classic Car Restorations',
                'owner_name' => 'Robert Brown',
                'slug' => 'classic-car-restorations',
                'email' => 'restore@classiccars.com',
                'phone' => '9876543214',
                'alternate_phone' => null,
                'website' => 'https://classicrestorations.com',
                'gst_number' => '24EEEEE4444E1Z5',
                'pan_number' => 'VWXYZ7890Q',
                'description' => 'Heritage Colony, Rajkot, Gujarat. Specializing in vintage and classic car restoration.',
                'business_type' => 'Restoration Shop',
                'established_year' => '2010',
                'employee_count' => 12,
                'status' => true,
            ],
            [
                'garage_name' => 'Modern Auto Tech',
                'owner_name' => 'Emily Davis',
                'slug' => 'modern-auto-tech',
                'email' => 'tech@modernauto.com',
                'phone' => '9876543215',
                'alternate_phone' => '9876543225',
                'website' => 'https://modernautotech.com',
                'gst_number' => '24FFFFF5555F1Z5',
                'pan_number' => 'ABCDE6789G',
                'description' => 'Tech Park Extension, Gandhinagar, Gujarat. Advanced diagnostics and EV repair center.',
                'business_type' => 'EV Specialist',
                'established_year' => '2023',
                'employee_count' => 6,
                'status' => true,
            ],
            [
                'garage_name' => 'Royal Mechanics',
                'owner_name' => 'David Wilson',
                'slug' => 'royal-mechanics',
                'email' => 'contact@royalmechanics.in',
                'phone' => '9876543216',
                'alternate_phone' => '9876543226',
                'website' => 'https://royalmechanics.in',
                'gst_number' => '24GGGGG6666G1Z5',
                'pan_number' => 'HIJKL0123H',
                'description' => 'Opposite Railway Station, Bhavnagar, Gujarat. Heavy vehicle and commercial truck repairs.',
                'business_type' => 'Commercial Vehicle Workshop',
                'established_year' => '2012',
                'employee_count' => 20,
                'status' => true,
            ],
        ];

        $plans = Plan::all();

        foreach ($garages as $garageData) {
            $garage = Garage::updateOrCreate(['slug' => $garageData['slug']], $garageData);

            // Assign a random plan if plans exist
            if ($plans->count() > 0) {
                $plan = $plans->random();
                Subscription::updateOrCreate(
                    ['garage_id' => $garage->id],
                    [
                        'plan_id' => $plan->id,
                        'billing_cycle' => 'monthly',
                        'amount' => $plan->monthly_price,
                        'starts_at' => now(),
                        'expires_at' => now()->addMonth(),
                        'status' => 'active',
                    ]
                );
            }
        }
    }
}
