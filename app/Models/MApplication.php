<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MApplication extends Model
{
    /** @use HasFactory<\Database\Factories\MApplicationFactory> */
    use HasFactory;

    protected $table = 'm_application';

    protected $primaryKey = 'app_id';

    // Set the primary key type to string (since it's a char field)
    protected $keyType = 'string';

    // Disable auto-incrementing for the primary key
    public $incrementing = false;





    // Disable timestamps if you don't have created_at and updated_at columns
    public $timestamps = false;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'app_name',
        'app_url',
        'environment',
        'img_url'
    ];

    protected static function boot()
    {
        parent::boot();

        // Handle the auto-incrementing logic for title_id
        static::creating(function ($model) {
            // Find the maximum existing title_id
            $lastId = self::orderByRaw("CAST(app_id AS INTEGER) DESC")->value('app_id');

            if ($lastId) {
                // Increment the numeric part of the last ID and keep it 5 digits long
                $newId = str_pad(((int) $lastId + 1), 5, '0', STR_PAD_LEFT);
            } else {
                // If no records exist, start with 00001
                $newId = '00001';
            }

            $model->app_id = $newId;
        });
    }

    public function mapCostCenterApplication()
    {
        return $this->hasMany(MapCostCenterApplication::class, 'app_id', 'app_id');
    }

    public function mapEmployeeApplication()
    {
        return $this->hasMany(MapEmployeeApplication::class, 'app_id', 'app_id');
    }
}
