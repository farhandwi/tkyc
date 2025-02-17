<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MTitle>
 */
class MTitleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_id' => $this->faker->unique()->regexify('[A-Z0-9]{10}'), // Random 10-character ID
            'title_name' => $this->faker->jobTitle, // Random job title
            'start_effective_date' => $this->faker->date(),
            'is_head' => $this->faker->boolean(),
            'end_effective_date' => $this->faker->optional()->date(), // Optional end date
        ];
    }
}
