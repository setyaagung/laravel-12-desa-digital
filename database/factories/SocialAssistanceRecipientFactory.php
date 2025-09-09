<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistanceRecipient>
 */
class SocialAssistanceRecipientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bank' => $this->faker->randomElement(['mandiri', 'bca', 'bni', 'bri']),
            'account_number' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'amount' => $this->faker->numberBetween(50000, 100000),
            'reason' => $this->faker->sentence(3),
            'proof' => $this->faker->imageUrl(640, 480),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}
