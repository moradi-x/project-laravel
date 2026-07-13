<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticateUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'min:6', 'string']
        ];
    }
}
