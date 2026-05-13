<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'status' => true,
        ]);
        $admin->assignRole('admin');

        // 2. Owner User
        $owner = User::create([
            'name' => 'Garage Owner',
            'email' => 'owner@owner.com',
            'password' => Hash::make('password'),
            'status' => true,
        ]);
        $owner->assignRole('owner');

        // 3. Staff User
        $staff = User::create([
            'name' => 'Garage Staff',
            'email' => 'staff@staff.com',
            'password' => Hash::make('password'),
            'status' => true,
        ]);
        $staff->assignRole('staff');
    }
}
