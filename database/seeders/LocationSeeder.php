<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $region = [
            [
                'name' => 'HQ Jedplc',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Azare',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Bauchi',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Bukuru',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Gboko',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Gombe',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Jos Metro',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Makurdi',
                'status' => 'Active',
                'created_by' => 1
            ],
            [
                'name' => 'Otukpo',
                'status' => 'Active',
                'created_by' => 1
            ]
        ];

        foreach($region as $key =>$value){
            location::create($value);
        }
    }
}
