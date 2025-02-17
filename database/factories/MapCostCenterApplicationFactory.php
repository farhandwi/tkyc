<?php

namespace Database\Factories;

use App\Models\MapCostCenterHierarchy;
use App\Models\MApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MapCostCenterApplication>
 */
class MapCostCenterApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'app_id' => MApplication::factory(),
            'cost_center' => MapCostCenterHierarchy::factory()

        ];
    }
}
