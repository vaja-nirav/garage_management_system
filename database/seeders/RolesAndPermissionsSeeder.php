<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define Modules
        $modules = [
            'plans',
            'garages',
            'subscriptions',
            'customers',
            'vehicles',
            'staff',
            'categories',
            'products',
            'suppliers',
            'purchases',
            'purchase_returns',
            'sales',
            'sale_returns',
            'appointments',
            'job_cards',
            'expenses',
            'reports',
            'roles'
        ];

        // Create Permissions
        foreach ($modules as $module) {
            Permission::firstOrCreate(['name' => "view $module"]);
            Permission::firstOrCreate(['name' => "create $module"]);
            Permission::firstOrCreate(['name' => "edit $module"]);
            Permission::firstOrCreate(['name' => "delete $module"]);
        }

        // Create Roles and Assign Permissions
        
        // 1. Admin (Full Access)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // 2. Owner (Full access to their garage data)
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);
        $ownerRole->syncPermissions(Permission::all());

        // 3. Staff (Restricted Access)
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $staffRole->syncPermissions([
            'view customers', 'create customers', 'edit customers',
            'view vehicles', 'create vehicles', 'edit vehicles',
            'view products',
            'view appointments', 'create appointments', 'edit appointments',
            'view job_cards', 'create job_cards', 'edit job_cards',
            'view sales', 'create sales'
        ]);
    }
}
