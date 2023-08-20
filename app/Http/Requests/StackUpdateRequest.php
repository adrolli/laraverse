<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StackUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'build' => ['nullable', 'max:255', 'json'],
            'public' => ['required', 'boolean'],
            'major' => ['nullable', 'boolean'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
