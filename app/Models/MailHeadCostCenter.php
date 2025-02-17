<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailHeadCostCenter extends Model
{
    protected $table = 'vwmail_head_cost_center';
    public $timestamps = false;
    
    protected $fillable = [
        'cost_center',
        'employee_name',
        'email',
        'email_cc'
    ];
}   