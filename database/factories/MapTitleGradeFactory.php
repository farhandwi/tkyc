<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MTitle;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MapTitleGrade>
 */
class MapTitleGradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_id' => MTitle::factory(), // Generate a related Title
            'grade_id' => $this->faker->unique()->regexify('[A-Z0-9]{10}'), // Random grade_id
        ];
    }
}
