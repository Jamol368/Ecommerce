<?php

namespace Database\Seeders;

use App\Models\ProductOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductOption::factory(200)
            ->hasProductInstance(1000)
            ->hasOptionValue(20)
            ->create();
    }
}
