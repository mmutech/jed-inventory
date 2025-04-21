<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pollinate_Units extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /**
         * Created by pollinate.
         *
         * Table: jed_inventory.units
         * User:  MMUHADEJIA
         * Host:  DESKTOP-R740F0R
         * Date:  2025-04-19 19:16:23 UTC
         * Env:   local
         */

        \Schema::disableForeignKeyConstraints();

        \DB::table('units')->delete();

        \DB::table('units')->insert([
            [
                'id' => 1,
                'description' => 'Meters',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'description' => 'No',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'description' => 'Carton',
                'status' => 'Active',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'description' => 'Packets',
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
