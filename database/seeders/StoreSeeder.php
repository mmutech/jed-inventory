<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = [
            [
                'store_id' => 1,
                'name' => 'Central Store',
                'store_officer' => 1,
                'location' => 2,
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'store_id' => 2,
                'name' => 'Test Store 1',
                'store_officer' => 1,
                'location' => 1,
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'store_id' => 3,
                'name' => 'Test Store 2',
                'store_officer' => 1,
                'location' => 3,
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'store_id' => 4,
                'name' => 'Test Store 3',
                'store_officer' => 1,
                'location' => 5,
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'store_id' => 5,
                'name' => 'Test Store 4',
                'store_officer' => 1,
                'location' => 2,
                'status' => 'Active',
                'created_by' => 1
            ],
        ];

        foreach($store as $key =>$value){
            Store::create($value);
        }
    }
}
