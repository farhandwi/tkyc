<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCostCenter  extends Model
{
    /** @use HasFactory<\Database\Factories\MCostCenterFactory> */
    use HasFactory;

    // Define the table name (optional if it doesn't follow Laravel's naming convention)
    protected $table = 'm_cost_center';

    // Define the primary key
    protected $primaryKey = 'id';

    // Set the primary key type to integer (since it's an int field)
    protected $keyType = 'int';

    // Disable auto-incrementing for the primary key (if necessary)
    public $incrementing = true;

    // Disable timestamps (since it's not being used)
    public $timestamps = false;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'old_id',
        'merge_id',
        'prod_ctr',
        'cost_ctr',
        'profit_ctr',
        'plant',
        'ct_description',
        'remark',
        'SKD',
        'TMT',
        'create_by',
        'exp_date',
    ];
    // Automatically handle `create_date` with current timestamp
    // protected $casts = [
    //     'create_date' => 'datetime:Y-m-d',
    //     'exp_date'    => 'datetime:Y-m-d',
    //     'TMT'         => 'datetime:Y-m-d',
    // ];

    // Boot method to auto-fill `create_date`
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->create_date = $model->create_date ?? now();
        });
    }
    public function mergedCostCenter()
    {
        return $this->hasOne(MCostCenter::class, 'id', 'merge_id');
    }
    public function oldCostCenter()
    {
        return $this->hasOne(MCostCenter::class, 'id', 'old_id');
    }
}
