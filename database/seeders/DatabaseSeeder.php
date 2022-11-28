<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DivisionSeeder::class,
            SupplierSeeder::class,
            ItemCategorySeeder::class,
            ItemSeeder::class,
            SavingSeeder::class,
            SettingSeeder::class,
            CooperativeSeeder::class,
        ]);
    }
}
