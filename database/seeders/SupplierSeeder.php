<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'garage_id' => 1,
                'supplier_code' => 'SUP-001',
                'company_name' => 'Global Auto Parts',
                'contact_person' => 'John Miller',
                'email' => 'sales@globalauto.com',
                'phone' => '555-0101',
                'gst_number' => '24AAAAA0000A1Z5',
                'address' => '123 Parts Ave, Detroit, MI',
            ],
            [
                'garage_id' => 1,
                'supplier_code' => 'SUP-002',
                'company_name' => 'Elite Tire Solutions',
                'contact_person' => 'Sarah Tyre',
                'email' => 'orders@elitetires.com',
                'phone' => '555-0202',
                'gst_number' => '24BBBBB1111B1Z5',
                'address' => '456 Rubber St, Akron, OH',
            ],
            [
                'garage_id' => 1,
                'supplier_code' => 'SUP-003',
                'company_name' => 'Premium Oil Co.',
                'contact_person' => 'Robert Fluid',
                'email' => 'support@premiumoil.com',
                'phone' => '555-0303',
                'gst_number' => '24CCCCC2222C1Z5',
                'address' => '789 Lubricant Blvd, Houston, TX',
            ],
            [
                'garage_id' => 1,
                'supplier_code' => 'SUP-004',
                'company_name' => 'Spark & Battery Experts',
                'contact_person' => 'Eleanor Volt',
                'email' => 'info@sparkexperts.com',
                'phone' => '555-0404',
                'gst_number' => '24DDDDD3333D1Z5',
                'address' => '101 Energy Dr, Chicago, IL',
            ],
            [
                'garage_id' => 1,
                'supplier_code' => 'SUP-005',
                'company_name' => 'Brake Master Distributors',
                'contact_person' => 'David Stop',
                'email' => 'sales@brakemaster.com',
                'phone' => '555-0505',
                'gst_number' => '24EEEEE4444E1Z5',
                'address' => '202 Safety Ln, Los Angeles, CA',
            ],
            [
                'garage_id' => 1,
                'supplier_code' => 'SUP-006',
                'company_name' => 'Coolant & Radiator World',
                'contact_person' => 'Alice Chill',
                'email' => 'orders@coolantworld.com',
                'phone' => '555-0606',
                'gst_number' => '24FFFFF5555F1Z5',
                'address' => '303 Frost Way, Denver, CO',
            ],
            [
                'garage_id' => 1,
                'supplier_code' => 'SUP-007',
                'company_name' => 'Engine Core Supply',
                'contact_person' => 'Michael Piston',
                'email' => 'm.piston@enginecore.com',
                'phone' => '555-0707',
                'gst_number' => '24GGGGG6666G1Z5',
                'address' => '404 Torque Rd, Charlotte, NC',
            ],
        ];

        foreach ($suppliers as $supplier) {
            \App\Models\Supplier::updateOrCreate(['supplier_code' => $supplier['supplier_code']], $supplier);
        }
    }
}
