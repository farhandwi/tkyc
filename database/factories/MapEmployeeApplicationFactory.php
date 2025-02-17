<?php

namespace Database\Factories;

use App\Models\MApplication;
use App\Models\MEmployeeGeneralInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MapEmployeeApplication>
 */
class MapEmployeeApplicationFactory extends Factory
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
            'PARTNER' => MEmployeeGeneralInfo::factory()
        ];
    }
}
