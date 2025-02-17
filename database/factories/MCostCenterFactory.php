<?php

namespace Database\Factories;

use App\Models\MapCostCenterHierarchy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MCostCenter>
 */
class MCostCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'old_id' => null,
            'merge_id' => null,
            'prod_ctr' => $this->faker->lexify('????'),
            'cost_ctr' => $this->faker->lexify('????'),
            'profit_ctr' => $this->faker->lexify('???????'),
            'plant' => $this->faker->numberBetween(1, 100),
            'ct_description' => $this->faker->sentence(),
            'remark' => $this->faker->sentence(),
            'SKD' => $this->faker->sentence(),
            'TMT' => $this->faker->date(),
            'create_by' => $this->faker->userName(),
            'exp_date' => $this->faker->date(),

        ];
    }
}
