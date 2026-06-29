<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Post::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:200'],
            'content' => ['required', 'string', 'min:3', 'max:100000'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'status' => ['required', 'in:active,inactive'],
            'thumbnail' => ['required', 'image'], // مرحله اول اعتبار سنجی
        ];
    }
}
