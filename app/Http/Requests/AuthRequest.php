<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()) {
            // Rules untuk POST request (misal untuk create)
            case 'POST':
                return [
                    'email' => 'required|email',
                    'refresh_token' => 'required|string',
                ];
            // Rules untuk DELETE request
            case 'DELETE':
                return [
                    'email' => 'required|email',
                    'refresh_token' => 'required|string',
                ];

            // Default rules (jika request method tidak terdefinisi)
            default:
                return [];
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email field is required',
            'refresh_token.required' => 'Refresh Token field is required',
        ];
    }

}