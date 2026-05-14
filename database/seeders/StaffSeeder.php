<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\Garage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StaffSeeder extends Seeder
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

        $staffMembers = [
            [
                'first_name' => 'Rahul',
                'last_name' => 'Sharma',
                'email' => 'rahul.sharma@example.com',
                'phone' => '9876500001',
                'designation' => 'Senior Mechanic',
                'gender' => 'male',
                'department' => 'Service',
                'employment_type' => 'Full-time',
                'salary_type' => 'Monthly',
                'basic_salary' => 25000.00,
            ],
            [
                'first_name' => 'Pooja',
                'last_name' => 'Verma',
                'email' => 'pooja.verma@example.com',
                'phone' => '9876500002',
                'designation' => 'Receptionist',
                'gender' => 'female',
                'department' => 'Front Office',
                'employment_type' => 'Full-time',
                'salary_type' => 'Monthly',
                'basic_salary' => 15000.00,
            ],
            [
                'first_name' => 'Sanjay',
                'last_name' => 'Singh',
                'email' => 'sanjay.singh@example.com',
                'phone' => '9876500003',
                'designation' => 'Electrician',
                'gender' => 'male',
                'department' => 'Electrical',
                'employment_type' => 'Full-time',
                'salary_type' => 'Monthly',
                'basic_salary' => 20000.00,
            ],
            [
                'first_name' => 'Anita',
                'last_name' => 'Patel',
                'email' => 'anita.patel@example.com',
                'phone' => '9876500004',
                'designation' => 'Accountant',
                'gender' => 'female',
                'department' => 'Accounts',
                'employment_type' => 'Full-time',
                'salary_type' => 'Monthly',
                'basic_salary' => 22000.00,
            ],
            [
                'first_name' => 'Vikram',
                'last_name' => 'Rathore',
                'email' => 'vikram.rathore@example.com',
                'phone' => '9876500005',
                'designation' => 'Service Advisor',
                'gender' => 'male',
                'department' => 'Service',
                'employment_type' => 'Full-time',
                'salary_type' => 'Monthly',
                'basic_salary' => 18000.00,
            ],
            [
                'first_name' => 'Deepak',
                'last_name' => 'Joshi',
                'email' => 'deepak.joshi@example.com',
                'phone' => '9876500006',
                'designation' => 'Helper',
                'gender' => 'male',
                'department' => 'General',
                'employment_type' => 'Contract',
                'salary_type' => 'Weekly',
                'basic_salary' => 3000.00,
            ],
            [
                'first_name' => 'Meera',
                'last_name' => 'Reddy',
                'email' => 'meera.reddy@example.com',
                'phone' => '9876500007',
                'designation' => 'Wash Manager',
                'gender' => 'female',
                'department' => 'Washing',
                'employment_type' => 'Full-time',
                'salary_type' => 'Monthly',
                'basic_salary' => 12000.00,
            ],
        ];

        foreach ($staffMembers as $index => $staffData) {
            $garage = $garages->random();
            Staff::updateOrCreate(
                ['email' => $staffData['email']],
                array_merge($staffData, [
                    'garage_id' => $garage->id,
                    'employee_code' => 'EMP-' . date('Y') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'dob' => now()->subYears(rand(20, 45))->format('Y-m-d'),
                    'joining_date' => now()->subMonths(rand(1, 24))->format('Y-m-d'),
                    'status' => true,
                    'notes' => 'Sample staff member for ' . $garage->garage_name,
                ])
            );
        }
    }
}
