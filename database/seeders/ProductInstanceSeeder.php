<?php

namespace Database\Seeders;

use App\Models\ProductInstance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductInstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductInstance::factory(1000)
            ->create();
    }
}
