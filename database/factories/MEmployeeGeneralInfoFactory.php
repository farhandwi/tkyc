<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MEmployeeGeneralInfo;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MEmployeeGeneralInfo>
 */
class MEmployeeGeneralInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = MEmployeeGeneralInfo::class;
    public function definition(): array
    {
        return [
            'BP' => $this->faker->unique()->lexify('??????????'), // Generate a random 10-character string
            'name' => $this->faker->name, // Use Faker to generate a name
            'address' => $this->faker->address,
        ];
    }
}
