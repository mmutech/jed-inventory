<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pollinate_PurchaseOrders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         * Created by pollinate.
         * 
         * Table: jed_test.purchase_orders
         * User:  MMUHADEJIA
         * Host:  DESKTOP-R740F0R
         * Date:  2024-03-05 08:08:26 UTC
         * Env:   local
         */

        \Schema::disableForeignKeyConstraints();

        \DB::table('purchase_orders')->delete();

        \DB::table('purchase_orders')->insert([
            [
                'id' => 1,
                'purchase_order_id' => 1,
                'purchase_order_no' => 'JED/PROC/01/24/001',
                'purchase_order_name' => 'Test Purchase Order One',
                'vendor_name' => 'Test Vendor One',
                'beneficiary' => 'Test Beneficiary One',
                'delivery_address' => 1,
                'purchase_order_date' => '2024-03-03',
                'status' => 'Completed',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-03-03 13:15:14',
                'updated_at' => '2024-03-03 13:24:13',
            ],
            [
                'id' => 2,
                'purchase_order_id' => 2,
                'purchase_order_no' => 'JED/PROC/01/24/002',
                'purchase_order_name' => 'Test Purchase Order Two',
                'vendor_name' => 'Test Vendor Two',
                'beneficiary' => 'Test Beneficiary Two',
                'delivery_address' => 1,
                'purchase_order_date' => '2024-03-04',
                'status' => 'Completed',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-03-04 13:21:35',
                'updated_at' => '2024-03-04 14:16:04',
            ],
            [
                'id' => 3,
                'purchase_order_id' => 3,
                'purchase_order_no' => 'JED/PROC/01/24/003',
                'purchase_order_name' => 'Test Purchase Order Three',
                'vendor_name' => 'Test Vendor Three',
                'beneficiary' => 'Test Beneficiary Three',
                'delivery_address' => 1,
                'purchase_order_date' => '2024-03-05',
                'status' => 'Completed',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-03-05 13:21:35',
                'updated_at' => '2024-03-05 14:16:04',
            ],
            [
                'id' => 4,
                'purchase_order_id' => 4,
                'purchase_order_no' => 'JED/PROC/01/24/004',
                'purchase_order_name' => 'Test Purchase Order Four',
                'vendor_name' => 'Test Vendor Four',
                'beneficiary' => 'Test Beneficiary Four',
                'delivery_address' => 1,
                'purchase_order_date' => '2024-03-06',
                'status' => 'Completed',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-03-06 13:21:35',
                'updated_at' => '2024-03-06 14:16:04',
            ],
            [
                'id' => 5,
                'purchase_order_id' => 5,
                'purchase_order_no' => 'JED/PROC/01/24/005',
                'purchase_order_name' => 'Test Purchase Order Five',
                'vendor_name' => 'Test Vendor Five',
                'beneficiary' => 'Test Beneficiary Five',
                'delivery_address' => 1,
                'purchase_order_date' => '2024-03-07',
                'status' => 'Completed',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => '2024-03-07 13:21:35',
                'updated_at' => '2024-03-07 14:16:04',
            ],
        ]);

        \Schema::enableForeignKeyConstraints();

    }
}
