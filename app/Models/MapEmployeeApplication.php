<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapEmployeeApplication extends Model
{
    /** @use HasFactory<\Database\Factories\MapEmployeeApplicationFactory> */
    use HasFactory;

    protected $table = 'map_employee_application';

    // You can leave this empty as we don't want timestamps for this pivot model
    public $timestamps = false;

    public $incrementing = false;

    // Define the primary key
    protected $primaryKey = ['PARTNER', 'app_id'];

    // Set the fields that can be mass-assigned
    protected $fillable = [
        'PARTNER',
        'app_id',
    ];

    // Define the relationship back to the Employee and Application models
    public function mEmployeeGeneralInfo()
    {
        return $this->belongsTo(MEmployeeGeneralInfo::class, 'PARTNER', 'BP');
    }

    public function mApplication()
    {
        return $this->belongsTo(MApplication::class, 'app_id', 'app_id');
    }
}
