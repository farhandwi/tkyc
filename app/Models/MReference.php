<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MReference extends Model
{
    /** @use HasFactory<\Database\Factories\MReferenceFactory> */
    use HasFactory;

    // Define the table name (optional if it's not plural)
    protected $table = 'm_reference';

    // Define the composite primary key
    protected $primaryKey = ['ref_id', 'ref_code'];

    // Set the data type of the primary key to string
    protected $keyType = 'string';

    // Disable auto-incrementing (since ref_id is not an auto-incrementing integer)
    public $incrementing = false;

    // Disable timestamps as we have custom date fields
    public $timestamps = false;

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'ref_id',
        'ref_code',
        'ref_id_group',
        'header_flag',
        'description',
        'create_by',
        'create_date',
        'modify_by',
        'modify_date',
        'expiry_date',
    ];
}
