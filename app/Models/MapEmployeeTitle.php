<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapEmployeeTitle extends Model
{
    /** @use HasFactory<\Database\Factories\MapEmployeeTitleFactory> */
    use HasFactory;
    // Table name
    protected $table = 'map_employee_title';

    // Disable auto-incrementing ID
    public $incrementing = false;

    // Primary Key
    protected $primaryKey = ['BP', 'cost_center', 'title_id', 'seq_nbr'];
    protected $keyType = 'string';

    // Disable timestamps
    public $timestamps = false;

    // Mass-assignable fields
    protected $fillable = [
        'BP',
        'cost_center',
        'title_id',
        'type',
        'start_effective_date',
        'end_effective_date',
        'remark',
        'status_pekerjaan',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mapEmployeeTitle) {
            // Fetch the largest seq_nbr for the given BP
            $largestSeqNbr = self::where('BP', $mapEmployeeTitle->BP)->max('seq_nbr');

            // Set seq_nbr to 1 if no records are found for the BP, otherwise increment the largest value
            $mapEmployeeTitle->seq_nbr = $largestSeqNbr ? $largestSeqNbr + 1 : 1;
        });
    }

    // Relationships
    public function mapCostCenterHierarchy()
    {
        return $this->belongsTo(MapCostCenterHierarchy::class, 'cost_center', 'cost_center');
    }
    public function mEmployeeGeneralInfo()
    {
        return $this->belongsTo(MEmployeeGeneralInfo::class, 'BP', 'BP');
    }

    public function mTitle()
    {
        return $this->belongsTo(MTitle::class, 'title_id', 'title_id');
    }
}
