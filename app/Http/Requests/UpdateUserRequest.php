<?php

namespace App\Http\Requests;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'status' => ['required', 'in:active,inactive'],
            'role' => ['required', Rule::enum(UserRoleEnum::class)]
        ];
    }
}
