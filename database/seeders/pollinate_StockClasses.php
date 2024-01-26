<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pollinate_StockClasses extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         * Created by pollinate.
         * 
         * Table: jed_inventory.stock_classes
         * User:  MMUHADEJIA
         * Host:  DESKTOP-R740F0R
         * Date:  2024-01-26 18:51:46 UTC
         * Env:   local
         */

        \Schema::disableForeignKeyConstraints();

        \DB::table('stock_classes')->delete();

        \DB::table('stock_classes')->insert([
            [
                'id' => 1,
                'name' => 'STD-46',
                'stock_category_id' => 1,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'STD-47',
                'stock_category_id' => 1,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'STD-44',
                'stock_category_id' => 2,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'STD-49',
                'stock_category_id' => 2,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'name' => 'STD-14',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_classes')->insert([
            [
                'id' => 6,
                'name' => 'STD-150',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 7,
                'name' => 'STD-16',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 8,
                'name' => 'STD-18',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 9,
                'name' => 'STD-19',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 10,
                'name' => 'STD-20',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_classes')->insert([
            [
                'id' => 11,
                'name' => 'STD-21',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 12,
                'name' => 'STD-22',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 13,
                'name' => 'STD-23',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 14,
                'name' => 'STD-24',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 15,
                'name' => 'STD-26',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_classes')->insert([
            [
                'id' => 16,
                'name' => 'STD-27',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 17,
                'name' => 'STD-29',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 18,
                'name' => 'STD-30',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 19,
                'name' => 'STD-33',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 20,
                'name' => 'STD-40',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_classes')->insert([
            [
                'id' => 21,
                'name' => 'STD-41',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 22,
                'name' => 'STD-43',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 23,
                'name' => 'STD-44',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 24,
                'name' => 'STD-45',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 25,
                'name' => 'STD-47',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_classes')->insert([
            [
                'id' => 26,
                'name' => 'STD-48',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 27,
                'name' => 'STD-49',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 28,
                'name' => 'STD-50',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 29,
                'name' => 'STD-53',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 30,
                'name' => 'STD-55',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_classes')->insert([
            [
                'id' => 31,
                'name' => 'STD-60',
                'stock_category_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 32,
                'name' => 'Meter',
                'stock_category_id' => 4,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 33,
                'name' => 'STD-61',
                'stock_category_id' => 4,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 34,
                'name' => 'NIV',
                'stock_category_id' => 5,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 35,
                'name' => 'STD-57',
                'stock_category_id' => 5,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_classes')->insert([
            [
                'id' => 36,
                'name' => 'Stationaries',
                'stock_category_id' => 7,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 37,
                'name' => 'STD-43',
                'stock_category_id' => 8,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 38,
                'name' => 'STD-14',
                'stock_category_id' => 6,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 39,
                'name' => 'STD-19',
                'stock_category_id' => 6,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \Schema::enableForeignKeyConstraints();

    }
}
