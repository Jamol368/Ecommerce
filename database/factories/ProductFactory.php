<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendor_id' => rand(1, 10),
            'category_id' => rand(1, 10),
            'product_brand_id' => rand(1, 20),
            'model' => fake()->text(31),
            'name' => fake()->text(255),
            'slug' => fake()->slug(3),
            'product_code' => fake()->text,
            'description' => fake()->text(255),
            'detail' => fake()->text,
            'tax' => 0,
            'currency_id' => rand(1, 2),
            'discount' => 0,
            'product_status_id' => rand(1, 2),
        ];
    }
}
