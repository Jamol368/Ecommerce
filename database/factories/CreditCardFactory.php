<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditCard>
 */
class CreditCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 2),
            'card_number' => fake()->unique()->creditCardNumber(),
            'expiration_month' => fake()->date('m'),
            'expiration_year' => fake()->date('y'),
            'phone' => '+998-(9'.rand(1, 9).')-'.rand(100, 999).'-'.rand(10, 99).'-'.rand(10, 99),
            'main' => fake()->randomElement([true, false])
        ];
    }
}
