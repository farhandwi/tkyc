<?php

namespace Database\Factories;

use App\Models\MEmployeeGeneralInfo;
use App\Models\MReference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MEmployeeAdditional>
 */
class MEmployeeAdditionalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'BP' => MEmployeeGeneralInfo::factory(),
            'PARTNEREXTERNAL' => $this->faker->regexify('[A-Z0-9]{10}'),
            'is_male' => true,
            'start_effective_date' => $this->faker->date(),
            'end_effective_date' => $this->faker->date(),
            'Remark' => $this->faker->sentence,
        ];
    }
}
