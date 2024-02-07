<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            //CreateAdminUserSeeder::class,
            PermissionTableSeeder::class,
            LocationSeeder::class,
            pollinate_StockCategories::class,
            pollinate_StockClasses::class,
            pollinate_StockCodes::class,
            pollinate_Units::class,
            StoreSeeder::class,
        ]);
        
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
