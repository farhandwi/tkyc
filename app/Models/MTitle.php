<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MTitle extends Model
{
    /** @use HasFactory<\Database\Factories\MTitleFactory> */
    use HasFactory;

    // Define the table name (optional if it doesn't follow Laravel's naming convention)
    protected $table = 'm_title';

    // Define the primary key
    protected $primaryKey = 'title_id';

    // Set the primary key type to string (since it's a char field)
    protected $keyType = 'string';

    // Disable auto-incrementing for the primary key
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // Define the fillable fields for mass assignments
    protected $fillable = [
        'title_name',
        "is_head",
        'start_effective_date',
        'end_effective_date',
    ];

    protected static function boot()
    {
        parent::boot();

        // Handle the auto-incrementing logic for title_id
        static::creating(function ($model) {
            // Find the maximum existing title_id
            $lastId = self::max('title_id');

            if ($lastId) {
                // Increment the numeric part of the last ID and keep it 5 digits long
                $newId = str_pad(((int) $lastId + 1), 5, '0', STR_PAD_LEFT);
            } else {
                // If no records exist, start with 00001
                $newId = '00001';
            }

            $model->title_id = $newId;
        });
    }
    public function mapTitleGrade()
    {
        return $this->hasMany(MapTitleGrade::class, 'title_id', 'title_id');
    }

    public function mapTitleCostCenter()
    {
        return $this->hasMany(MapTitleCostCenter::class, 'title_id', 'title_id');
    }
    public function mapEmployeeTitle()
    {
        return $this->hasMany(MapEmployeeTitle::class, 'title_id', 'title_id');
    }
}
