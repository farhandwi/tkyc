<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MApplication>
 */
class MApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'app_id' => $this->faker->unique()->lexify('?????'), // Random 5-character string for app_id
            'app_name' => $this->faker->company, // Random company name for app_name
            'app_url' => $this->faker->url, // Random URL for app_url
            'environment' => $this->faker->numberBetween(100, 999), // Generates a random integer between 100 and 999

        ];
    }
}
