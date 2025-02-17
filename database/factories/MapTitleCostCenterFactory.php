<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MTitle;
use App\Models\MapCostCenterHierarchy;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MapTitleCostCenter>
 */
class MapTitleCostCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_id' => MTitle::factory(), // Generate related Title
            'cost_center' => MapCostCenterHierarchy::factory(), // Generate related CostCenter
            'is_head' => $this->faker->boolean(), // Random boolean
        ];
    }
}
