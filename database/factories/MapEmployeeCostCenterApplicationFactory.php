<?php

namespace Database\Factories;

use App\Models\MApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MapEmployeeCostCenterApplication>
 */
class MapEmployeeCostCenterApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'BC' => $this->faker->bothify('??????????'), // Random 10 characters, replace with real BC logic if needed
            'app_id' => MApplication::factory(), // Random 10 characters for app_id, replace as needed
            'start_effective_date' => $this->faker->date(),
            'end_effective_date' => $this->faker->date(),
        ];
    }
}
