<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapCostCenterApplication extends Model
{
    /** @use HasFactory<\Database\Factories\MapCostCenterApplicationFactory> */
    use HasFactory;
    public $timestamps = false;

    // Specify the table name (optional if the table name follows Laravel's conventions)
    protected $table = 'map_cost_center_application';

    public $incrementing = false;

    // Define the primary key
    protected $primaryKey = ['cost_center', 'app_id'];

    // Set the fields that can be mass-assigned
    protected $fillable = [
        'cost_center',
        'app_id',
    ];

    public function costCenterHierarchy()
    {
        return $this->belongsTo(MapCostCenterHierarchy::class, 'cost_center', 'cost_center');
    }
    public function mApplication()
    {
        return $this->belongsTo(MApplication::class, 'app_id', 'app_id');
    }
}
