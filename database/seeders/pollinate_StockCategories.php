<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pollinate_StockCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         * Created by pollinate.
         *
         * Table: jed_inventory.stock_categories
         * User:  MMUHADEJIA
         * Host:  DESKTOP-R740F0R
         * Date:  2025-04-19 19:16:22 UTC
         * Env:   local
         */

        \Schema::disableForeignKeyConstraints();

        \DB::table('stock_categories')->delete();

        \DB::table('stock_categories')->insert([
            [
                'id' => 1,
                'name' => 'Cable & conductor',
                'stock_class_id' => 1,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Cable & conductor',
                'stock_class_id' => 2,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Insulator',
                'stock_class_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'Insulator',
                'stock_class_id' => 4,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'name' => 'Material consumable',
                'stock_class_id' => 5,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 6,
                'name' => 'Material consumable',
                'stock_class_id' => 6,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 7,
                'name' => 'Material consumable',
                'stock_class_id' => 7,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 8,
                'name' => 'Material consumable',
                'stock_class_id' => 8,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 9,
                'name' => 'Material consumable',
                'stock_class_id' => 9,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 10,
                'name' => 'Material consumable',
                'stock_class_id' => 10,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 11,
                'name' => 'Material consumable',
                'stock_class_id' => 11,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 12,
                'name' => 'Material consumable',
                'stock_class_id' => 12,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 13,
                'name' => 'Material consumable',
                'stock_class_id' => 13,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 14,
                'name' => 'Material consumable',
                'stock_class_id' => 14,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 15,
                'name' => 'Material consumable',
                'stock_class_id' => 15,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 16,
                'name' => 'Material consumable',
                'stock_class_id' => 16,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 17,
                'name' => 'Material consumable',
                'stock_class_id' => 17,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 18,
                'name' => 'Material consumable',
                'stock_class_id' => 18,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 19,
                'name' => 'Material consumable',
                'stock_class_id' => 19,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 20,
                'name' => 'Material consumable',
                'stock_class_id' => 20,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 21,
                'name' => 'Material consumable',
                'stock_class_id' => 21,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 22,
                'name' => 'Material consumable',
                'stock_class_id' => 22,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 23,
                'name' => 'Material consumable',
                'stock_class_id' => 3,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 24,
                'name' => 'Material consumable',
                'stock_class_id' => 23,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 25,
                'name' => 'Material consumable',
                'stock_class_id' => 2,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 26,
                'name' => 'Material consumable',
                'stock_class_id' => 24,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 27,
                'name' => 'Material consumable',
                'stock_class_id' => 4,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 28,
                'name' => 'Material consumable',
                'stock_class_id' => 25,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 29,
                'name' => 'Material consumable',
                'stock_class_id' => 26,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 30,
                'name' => 'Material consumable',
                'stock_class_id' => 27,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 31,
                'name' => 'Material consumable',
                'stock_class_id' => 28,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 32,
                'name' => 'Meter',
                'stock_class_id' => 29,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 33,
                'name' => 'Meter',
                'stock_class_id' => 30,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 34,
                'name' => 'Other Stock',
                'stock_class_id' => 31,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 35,
                'name' => 'Stationaries',
                'stock_class_id' => 32,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 36,
                'name' => 'Material consumable',
                'stock_class_id' => 31,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 37,
                'name' => 'Stationaries',
                'stock_class_id' => 31,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 38,
                'name' => 'Other Stock',
                'stock_class_id' => 33,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 39,
                'name' => 'Wooden Concrete Pole',
                'stock_class_id' => 5,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 40,
                'name' => 'Wooden Concrete Pole',
                'stock_class_id' => 9,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);

        \DB::table('stock_categories')->insert([
            [
                'id' => 41,
                'name' => 'Other Stock',
                'stock_class_id' => 34,
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 42,
                'name' => 'Transformer -WIP',
                'stock_class_id' => 22,
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
