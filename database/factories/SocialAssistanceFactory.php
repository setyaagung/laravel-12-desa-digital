<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistance>
 */
class SocialAssistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => $this->faker->imageUrl(),
            'name' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(['staple', 'cash', 'subsidized_fuel', 'health']),
            'amount' => $this->faker->numberBetween(1000000, 10000000),
            'provider' => $this->faker->company(),
            'description' => $this->faker->sentence(),
            'is_available' => true,
        ];
    }
}
