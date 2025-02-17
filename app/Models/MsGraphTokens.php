<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MsGraphTokens extends Model
{
    protected $table = 'ms_graph_tokens';
    public $incrementing = true;
    public $timestamps = true;

    // Kolom yang bisa diisi
    protected $fillable = [
        'email',
        'refresh_token',
        'access_token'
    ];
}
