<?php
// app/Models/DotsApproval.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DotsApproval extends Model
{
    protected $table = 'vwdots_approval';
    public $timestamps = false;
    
    protected $fillable = [
        'cost_center',
        'cost_center_name',
        'cost_center_apv_1',
        'cost_center_apv_2',
        'BP',
        'employee_name',
        'role_user',
        'title_name',
        'email',
        'sex'
    ];
}