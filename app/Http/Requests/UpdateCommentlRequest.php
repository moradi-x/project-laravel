<?php

namespace App\Http\Requests;

use App\Enums\CommentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCommentlRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        return [
            
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'comment' => ['required', 'string', 'min:5', 'max:10000'],
            'status' => ['required', Rule::enum(CommentStatusEnum::class)],
        
        ];
    }
}
