<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'family' => ['required', 'string', 'min:3', 'max:100'],
            'avatar' => ['nullable', 'image'],
            'password' => ['nullable', 'string', 'min:8', 'max:100', 'confirmed'],
        ];
    }
}
