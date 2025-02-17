<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapTitleGrade extends Model
{
    /** @use HasFactory<\Database\Factories\MapTitleGradeFactory> */
    use HasFactory;

    // Define the table name
    protected $table = 'map_title_grade';



    // Disable auto-incrementing as we are using a composite primary key
    public $incrementing = false;

    // Disable timestamps
    public $timestamps = false;

    // Define fillable attributes
    protected $fillable = [
        'title_id',
        'grade_id',
    ];

    // Define relationships
    public function mTitle()
    {
        return $this->belongsTo(MTitle::class, 'title_id', 'title_id');
    }

    public function scopeTitleId($query, $title_id)
    {
        return $query->where('title_id', $title_id);
    }
}
