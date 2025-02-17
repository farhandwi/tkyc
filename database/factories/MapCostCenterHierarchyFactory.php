<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MapCostCenterHierarchy>
 */
class MapCostCenterHierarchyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cost_center' => $this->faker->unique()->regexify('[A-Z0-9]{10}'), // Random 10-character code
            'cost_center_name' => $this->faker->company, // Random company name
            'cost_center_direct_report' => null,
            'cost_center_poss' => null,
            'cost_center_dh' => null,
            'cost_center_gh' => null,
            'cost_center_vp' => null,
            'cost_center_svp' => null,
            'cost_center_dir' => null,
            'start_effective_date' => $this->faker->date(),
            'end_effective_date' => $this->faker->optional()->date(),
        ];
    }
}
