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
         * Date:  2024-01-26 18:40:56 UTC
         * Env:   local
         */

        \Schema::disableForeignKeyConstraints();

        \DB::table('stock_categories')->delete();

        \DB::table('stock_categories')->insert([
            [
                'id' => 1,
                'name' => 'Cable & conductor',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'Insulator',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'Material consumable',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'Meter',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'name' => 'Other Stock',
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
                'name' => 'Wooden Concrete Pole',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 7,
                'name' => 'Stationaries',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 8,
                'name' => 'Transformer -WIP',
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
