<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MEmployeeGeneralInfo extends Model
{
    use HasFactory;
    /** @use HasFactory<\Database\Factories\MEmployeeGeneralInfoFactory> */
    protected $table = 'm_employee_general_info';

    // Primary key
    protected $primaryKey = 'BP';

    // Disable auto-incrementing (since 'BP' is not an integer)
    public $incrementing = false;

    // Primary key type
    protected $keyType = 'string';

    // Mass assignable attributes
    protected $fillable = ['BP', 'name', 'address', 'email', 'KTP', 'NPWP',  "phone_number"];

    // Optional: Disable timestamps if not needed
    public $timestamps = false;
    protected static function boot()
    {
        parent::boot();

        // Handle the auto-incrementing logic for title_id
        static::creating(function ($model) {
            // Find the maximum existing BP starting with "99"
            $lastBP = self::where('BP', 'like', '99%')->max('BP');

            if ($lastBP) {
                // Extract the numeric part after "99" and increment it
                $numericPart = (int) substr($lastBP, 2); // Get everything after "99"
                $newBP = '99' . str_pad($numericPart + 1, 8, '0', STR_PAD_LEFT); // Pad to keep 10 characters
            } else {
                // If no records exist, start with 990000000001
                $newBP = '9900000001';
            }

            $model->BP = $newBP;
        });
    }

    public function mEmployeeAdditional()
    {
        return $this->hasOne(MEmployeeAdditional::class, 'BP', 'BP');
    }
    public function mapEmployeeTitle()
    {
        return $this->hasMany(MapEmployeeTitle::class, 'BP', 'BP');
    }
    public function MapEmployeeApplication()
    {
        return $this->hasMany(MapEmployeeApplication::class, 'PARTNER', 'BP');
    }
}
