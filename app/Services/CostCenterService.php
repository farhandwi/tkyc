<?php

namespace App\Services;

use App\Models\MapCostCenterHierarchy;
use App\Models\MCostCenter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CostCenterService
{

    public function getAllCostCenters()
    {
        return MapCostCenterHierarchy::all();
    }

    public function doesCostCenterExist(string $id): bool
    {
        return MapCostCenterHierarchy::where('cost_center', $id)->exists();
    }
    public function getCostCenterById(string $id): ?MapCostCenterHierarchy
    {
        return MapCostCenterHierarchy::where('cost_center', $id)->first();
    }
}
