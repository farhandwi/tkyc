<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapTitleCostCenter extends Model
{
    /** @use HasFactory<\Database\Factories\MapTitleCostCenterFactory> */
    use HasFactory;


    // Define the table name
    protected $table = 'map_title_cost_center';

    // Disable auto-incrementing as we are using a composite primary key
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // Define fillable attributes
    protected $fillable = [
        'title_id',
        'cost_center',
    ];

    // Define relationships
    public function mTitle()
    {
        return $this->belongsTo(MTitle::class, 'title_id', 'title_id');
    }

    public function mapCostCenterHierarchy()
    {
        return $this->belongsTo(MapCostCenterHierarchy::class, 'cost_center', 'cost_center');
    }

    public function scopeTitleId($query, $title_id)
    {
        return $query->where('title_id', $title_id);
    }
}
