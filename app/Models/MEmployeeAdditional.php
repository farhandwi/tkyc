<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MEmployeeAdditional extends Model
{
    /** @use HasFactory<\Database\Factories\MEmployeeAdditionalFactory> */
    use HasFactory;
    // Define the table name (optional if it's not plural)
    protected $table = 'm_employee_additional';

    // Define the primary key
    protected $primaryKey = 'BP';

    // Set the data type of the primary key to string
    protected $keyType = 'string';

    // Disable auto-incrementing (since BP is not an auto-incrementing integer)
    public $incrementing = false;

    // Optional: Disable timestamps if not needed
    public $timestamps = false;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'BP',
        'PARTNEREXTERNAL',
        'is_male',
        'start_effective_date',
        'tmt',
        'Remark',
        'NIP',
        'NIP_2',
        'agama',
        'UID',
        'tanggal_lahir',
        'tanggal_masuk',
        'fakultas',
        'lokasi_pekerjaan',
        'pendidikan_terakhir',
        "university",
    ];


    public function mEmployeeGeneralInfo()
    {
        return $this->belongsTo(MEmployeeGeneralInfo::class, 'BP', 'BP');
    }
}
