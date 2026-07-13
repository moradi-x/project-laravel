<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequeset extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3 , max:50'],
            'family' => ['required', 'string', 'min:3 , max:50'],
            'email' => ['required', 'email', 'string', 'unique:users', 'max:100'],
            'password' => ['required', 'string', 'min:6, max:100', 'confirmed'],
        ];
    }
}
