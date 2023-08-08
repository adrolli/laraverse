<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemUpdateRequest extends FormRequest
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
            'vendor_id' => ['required', 'exists:vendors,id'],
            'type_id' => ['required', 'exists:types,id'],
            'website' => ['required', 'max:255', 'string'],
            'rating' => ['required', 'max:255', 'string'],
            'health' => ['required', 'max:255', 'string'],
            'github_url' => ['required', 'max:255', 'string'],
            'github_stars' => ['required', 'numeric'],
            'github_forks' => ['required', 'numeric'],
            'github_json' => ['required', 'max:255', 'json'],
            'packagist_url' => ['required', 'max:255', 'string'],
            'packagist_name' => ['required', 'max:255', 'string'],
            'packagist_description' => ['required', 'max:255', 'string'],
            'packagist_downloads' => ['required', 'numeric'],
            'packagist_favers' => ['required', 'numeric'],
            'npm_url' => ['required', 'max:255', 'string'],
            'github_maintainers' => ['required', 'numeric'],
        ];
    }
}
