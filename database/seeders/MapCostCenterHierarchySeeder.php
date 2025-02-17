<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MapCostCenterHierarchy;

class MapCostCenterHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MapCostCenterHierarchy::factory()->count(10)->create();

        // After initial creation, update foreign keys
        $costCenters = MapCostCenterHierarchy::all();
        foreach ($costCenters as $costCenter) {
            $costCenter->update([
                'cost_center_direct_report' => $costCenters->random()->cost_center,
                'cost_center_poss' => $costCenters->random()->cost_center,
                'cost_center_dh' => $costCenters->random()->cost_center,
                'cost_center_svp' => $costCenters->random()->cost_center,
                'cost_center_dir' => $costCenters->random()->cost_center,

                // Repeat for other foreign keys as needed
            ]);
        }
    }
}
