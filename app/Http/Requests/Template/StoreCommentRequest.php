<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        if ($this->expectsJson()) {
            return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'string', 'max:100'],
            'comment' => ['required', 'string', 'min:3', 'max:10000'],
        ];
        }else{
            return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'email', 'string', 'max:100'],
            'comment' => ['required', 'string', 'min:3', 'max:10000'],
            'captcha' => ['required', 'captcha']
        ];
        }
        
    }
}
