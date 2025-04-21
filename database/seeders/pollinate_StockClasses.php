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
         * Date:  2025-04-19 19:16:22 UTC
         * Env:   local
         */

        \Schema::disableForeignKeyConstraints();

        \DB::table('stock_classes')->delete();

        \DB::table('stock_classes')->insert([
            [
                'id' => 1,
                'name' => 'STD-46',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'STD-47',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'name' => 'STD-44',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'name' => 'STD-49',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'name' => 'STD-14',
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
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 7,
                'name' => 'STD-16',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 8,
                'name' => 'STD-18',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 9,
                'name' => 'STD-19',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 10,
                'name' => 'STD-20',
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
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 12,
                'name' => 'STD-22',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 13,
                'name' => 'STD-23',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 14,
                'name' => 'STD-24',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 15,
                'name' => 'STD-26',
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
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 17,
                'name' => 'STD-29',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 18,
                'name' => 'STD-30',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 19,
                'name' => 'STD-33',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 20,
                'name' => 'STD-40',
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
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 22,
                'name' => 'STD-43',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 23,
                'name' => 'STD-45',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 24,
                'name' => 'STD-48',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 25,
                'name' => 'STD-50',
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
                'name' => 'STD-53',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 27,
                'name' => 'STD-55',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 28,
                'name' => 'STD-60',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 29,
                'name' => 'Meter',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 30,
                'name' => 'STD-61',
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
                'name' => 'NIV',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 32,
                'name' => 'Stationaries',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 33,
                'name' => 'STD',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 34,
                'name' => 'STD-57',
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
