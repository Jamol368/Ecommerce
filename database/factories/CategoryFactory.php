<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parent_id' => rand(1, 30),
            'name' => fake()->unique()->text,
            'slug' => fake()->unique()->slug,
            'category_status_id' => rand(1, 2),
            'image' => fake()->image
        ];
    }
}
