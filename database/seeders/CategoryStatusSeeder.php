<?php

namespace Database\Seeders;

use App\Models\CategoryStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryStatus::factory(2)
            ->create();
    }
}
