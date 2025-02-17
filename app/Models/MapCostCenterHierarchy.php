<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapCostCenterHierarchy extends Model
{
    /** @use HasFactory<\Database\Factories\MapCostCenterHierarchyFactory> */
    use HasFactory;

    // Define the table name (optional if it's not plural)
    protected $table = 'map_cost_center_hierarchy';

    // Define the primary key
    protected $primaryKey = 'cost_center';

    // Set the data type of the primary key to string (since it's a 'char' column)
    protected $keyType = 'string';

    // Disable auto-incrementing (since BP is not an auto-incrementing integer)
    public $incrementing = false;

    // Disable timestamps since custom date fields are being used
    public $timestamps = false;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'cost_center',
        'cost_center_name',
        'cost_center_direct_report',
        'cost_center_poss',
        'cost_center_dh',
        'cost_center_gh',
        'cost_center_svp',
        'cost_center_dir',
        'start_effective_date',
        'end_effective_date',
    ];

    public function mapTitleCostCenter()
    {
        return $this->hasMany(MapTitleCostCenter::class, 'cost_center', 'cost_center');
    }
    public function directReport()
    {
        return $this->belongsTo(self::class, 'cost_center_direct_report', 'cost_center');
    }

    public function poss()
    {
        return $this->belongsTo(self::class, 'cost_center_poss', 'cost_center');
    }

    public function dh()
    {
        return $this->belongsTo(self::class, 'cost_center_dh', 'cost_center');
    }

    public function gh()
    {
        return $this->belongsTo(self::class, 'cost_center_gh', 'cost_center');
    }


    public function svp()
    {
        return $this->belongsTo(self::class, 'cost_center_svp', 'cost_center');
    }

    public function dir()
    {
        return $this->belongsTo(self::class, 'cost_center_dir', 'cost_center');
    }



    public function mapEmployeeTitle()
    {
        return $this->hasMany(MapEmployeeTitle::class, 'cost_center', 'cost_center');
    }

    public function mapCostCenterApplication()
    {
        return $this->hasMany(MapCostCenterApplication::class, 'cost_center', 'cost_center');
    }
}
