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
//             CategorySeeder::class,
//             CategoryStatusSeeder::class,
//             StateSeeder::class,
//             CitySeeder::class,
//             TagSeeder::class,
//             CurrencySeeder::class,
//             OptionSeeder::class,
//             OptionValueSeeder::class,
//             ProductBrandSeeder::class,
//             ProductStatusSeeder::class,
//             RoleSeeder::class,
//             UserSeeder::class,
//             VendorSeeder::class,
//             ProductInstanceSeeder::class,
             ImageSeeder::class,
//             ProductTagSeeder::class,
//             ProductOptionSeeder::class,
//             FavoriteSeeder::class,
         ]);
    }
}
