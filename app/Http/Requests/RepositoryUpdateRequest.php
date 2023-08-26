<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RepositoryUpdateRequest extends FormRequest
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
            'license' => ['required', 'max:255', 'string'],
            'readme' => ['required', 'max:255', 'string'],
            'data' => ['required', 'max:255', 'json'],
            'composer' => ['required', 'max:255', 'json'],
            'npm' => ['required', 'max:255', 'json'],
            'code_analyzer' => ['required', 'max:255', 'json'],
            'package_type' => ['required', 'max:255', 'string'],
            'repository_type_id' => ['required', 'exists:repository_types,id'],
            'organization_id' => ['required', 'exists:organizations,id'],
            'owner_id' => ['required', 'exists:owners,id'],
        ];
    }
}
