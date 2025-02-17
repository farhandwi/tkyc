<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MReference>
 */
class MReferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ref_id' => $this->faker->unique()->regexify('[A-Z0-9]{5}'),
            'ref_code' => $this->faker->regexify('[A-Z0-9]{5}'),
            'ref_id_group' => $this->faker->regexify('[A-Z0-9]{5}'),
            'header_flag' => $this->faker->randomElement(['Y', 'N']), // 'Y' or 'N'
            'description' => $this->faker->sentence,
            'create_by' => $this->faker->name,
            'create_date' => $this->faker->dateTimeThisYear,
            'modify_by' => $this->faker->name,
            'modify_date' => $this->faker->dateTimeThisYear,
            'expiry_date' => $this->faker->optional()->dateTimeThisYear, // Optional expiry date
        ];
    }
}
