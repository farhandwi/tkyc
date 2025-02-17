<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostCenterApprovalRequest extends FormRequest
{
    public function rules()
    {
        return [
            'approval1' => 'nullable|string|max:10',
            'approval2' => 'nullable|string|max:10',
            'approval3' => 'nullable|string|max:10',
            'approval4' => 'nullable|string|max:10',
            'approval5' => 'nullable|string|max:10',
            'bp' => 'required|string|max:10',
            'cost_center' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
        ];
    }
}