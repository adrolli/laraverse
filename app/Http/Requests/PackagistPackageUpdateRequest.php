<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackagistPackageUpdateRequest extends FormRequest
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
            'data' => ['required', 'max:255', 'json'],
            'type' => ['nullable', 'max:255', 'string'],
            'repository_updated' => ['required', 'boolean'],
        ];
    }
}
