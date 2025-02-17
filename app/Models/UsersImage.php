<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersImage extends Model
{
    protected $table = 'users_image';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'bp';
    protected $fillable = [
        'bp',
        'image_data'
    ];
}
