<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 3),
            'name' => fake()->company,
            'slug' => fake()->slug,
            'image' => '4d7xTJdVXHzFqZaCXAVg2g0wVq6ss5UOkxwmpB3Z.png',
            'description' => fake()->text(255),
            'manager' => fake()->name,
            'state_id' => fake()->numberBetween(1, 10),
            'city_id' => fake()->numberBetween(1, 50),
            'address' => fake()->text(255),
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'phone' => fake()->phoneNumber,
        ];
    }
}
