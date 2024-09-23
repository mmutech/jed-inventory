<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pollinate_Items extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         * Created by pollinate.
         * 
         * Table: jed_test.items
         * User:  MMUHADEJIA
         * Host:  DESKTOP-R740F0R
         * Date:  2024-03-05 08:09:41 UTC
         * Env:   local
         */

        \Schema::disableForeignKeyConstraints();

        \DB::table('items')->delete();

        \DB::table('items')->insert([
            [
                'id' => 1,
                'purchase_order_id' => 1,
                'description' => 'HT Reinforced Concrete Poles',
                'unit' => 1,
                'quantity' => 20,
                'rate' => 55000,
                'updated_by' => null,
                'confirm_qty' => 20,
                'confirm_rate' => 55000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 256,
                'confirm_date' => null,
                'created_at' => '2024-03-03 13:15:14',
                'updated_at' => '2024-03-03 13:23:52',
            ],
            [
                'id' => 2,
                'purchase_order_id' => 1,
                'description' => 'LT Reinforced Concrete Poles',
                'unit' => 1,
                'quantity' => 10,
                'rate' => 50000,
                'updated_by' => null,
                'confirm_qty' => 10,
                'confirm_rate' => 50000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 512,
                'confirm_date' => null,
                'created_at' => '2024-03-03 13:15:14',
                'updated_at' => '2024-03-03 13:23:52',
            ],
            [
                'id' => 3,
                'purchase_order_id' => 1,
                'description' => '50mm Aluminium Conductor',
                'unit' => 2,
                'quantity' => 1300,
                'rate' => 1300,
                'updated_by' => null,
                'confirm_qty' => 1300,
                'confirm_rate' => 1300,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 2,
                'confirm_date' => null,
                'created_at' => '2024-03-03 13:15:14',
                'updated_at' => '2024-03-03 13:23:53',
            ],
            [
                'id' => 4,
                'purchase_order_id' => 2,
                'description' => 'HT Reinforced Concrete Poles',
                'unit' => 1,
                'quantity' => 10,
                'rate' => 56000,
                'updated_by' => null,
                'confirm_qty' => 10,
                'confirm_rate' => 56000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 256,
                'confirm_date' => null,
                'created_at' => '2024-03-04 13:21:35',
                'updated_at' => '2024-03-04 14:15:44',
            ],
            [
                'id' => 5,
                'purchase_order_id' => 2,
                'description' => 'LT Reinforced Concrete Poles',
                'unit' => 1,
                'quantity' => 10,
                'rate' => 51000,
                'updated_by' => null,
                'confirm_qty' => 10,
                'confirm_rate' => 51000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 512,
                'confirm_date' => null,
                'created_at' => '2024-03-04 13:21:35',
                'updated_at' => '2024-03-04 14:15:45',
            ],
        ]);

        \DB::table('items')->insert([
            [
                'id' => 6,
                'purchase_order_id' => 2,
                'description' => '50mm Aluminium Conductor',
                'unit' => 2,
                'quantity' => 500,
                'rate' => 1350,
                'updated_by' => null,
                'confirm_qty' => 500,
                'confirm_rate' => 1350,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 2,
                'confirm_date' => null,
                'created_at' => '2024-03-04 13:21:35',
                'updated_at' => '2024-03-04 14:15:46',
            ],
            [
                'id' => 7,
                'purchase_order_id' => 3,
                'description' => '150mm2 Aluminium Conductor',
                'unit' => 2,
                'quantity' => 200,
                'rate' => 1450,
                'updated_by' => null,
                'confirm_qty' => 200,
                'confirm_rate' => 1450,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 2,
                'confirm_date' => null,
                'created_at' => '2024-03-05 13:21:35',
                'updated_at' => '2024-03-05 14:15:46',
            ],
            [
                'id' => 8,
                'purchase_order_id' => 3,
                'description' => 'HT Reinforced Concrete Poles',
                'unit' => 1,
                'quantity' => 20,
                'rate' => 54000,
                'updated_by' => null,
                'confirm_qty' => 20,
                'confirm_rate' => 54000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 256,
                'confirm_date' => null,
                'created_at' => '2024-03-05 13:21:35',
                'updated_at' => '2024-03-05 14:15:46',
            ],
            [
                'id' => 9,
                'purchase_order_id' => 4,
                'description' => 'HP Laserjet Printer',
                'unit' => 1,
                'quantity' => 10,
                'rate' => 60000,
                'updated_by' => null,
                'confirm_qty' => 10,
                'confirm_rate' => 60000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 1853,
                'confirm_date' => null,
                'created_at' => '2024-03-06 13:21:35',
                'updated_at' => '2024-03-06 14:15:46',
            ],
            [
                'id' => 10,
                'purchase_order_id' => 4,
                'description' => 'HP Desktop Computer',
                'unit' => 1,
                'quantity' => 10,
                'rate' => 160000,
                'updated_by' => null,
                'confirm_qty' => 10,
                'confirm_rate' => 160000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 1593,
                'confirm_date' => null,
                'created_at' => '2024-03-06 13:21:35',
                'updated_at' => '2024-03-06 14:15:46',
            ],
        ]);

        \DB::table('items')->insert([
            [
                'id' => 11,
                'purchase_order_id' => 5,
                'description' => 'RAIN BOOT',
                'unit' => 1,
                'quantity' => 10,
                'rate' => 50000,
                'updated_by' => null,
                'confirm_qty' => 10,
                'confirm_rate' => 50000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 1899,
                'confirm_date' => null,
                'created_at' => '2024-03-07 13:21:35',
                'updated_at' => '2024-03-07 14:15:46',
            ],
            [
                'id' => 12,
                'purchase_order_id' => 5,
                'description' => 'RAIN COAT',
                'unit' => 1,
                'quantity' => 10,
                'rate' => 300000,
                'updated_by' => null,
                'confirm_qty' => 10,
                'confirm_rate' => 30000,
                'confirm_by' => 1,
                'quality_check' => null,
                'stock_code' => 1874,
                'confirm_date' => null,
                'created_at' => '2024-03-07 13:21:35',
                'updated_at' => '2024-03-07 14:15:46',
            ],
        ]);

        \Schema::enableForeignKeyConstraints();

    }
}
