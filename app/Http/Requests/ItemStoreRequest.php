<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
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
            'latest_version' => ['required', 'max:255', 'string'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'type_id' => ['required', 'exists:types,id'],
            'website' => ['nullable', 'max:255', 'string'],
            'rating' => ['nullable', 'max:255', 'string'],
            'health' => ['nullable', 'max:255', 'string'],
            'github_url' => ['nullable', 'max:255', 'string'],
            'github_stars' => ['nullable', 'numeric'],
            'packagist_url' => ['nullable', 'max:255', 'string'],
            'packagist_name' => ['nullable', 'max:255', 'string'],
            'packagist_description' => ['nullable', 'max:255', 'string'],
            'packagist_downloads' => ['nullable', 'numeric'],
            'packagist_favers' => ['nullable', 'numeric'],
            'npm_url' => ['nullable', 'max:255', 'string'],
            'github_maintainers' => ['nullable', 'numeric'],
            'github_repo_id' => ['nullable', 'exists:github_repos,id'],
            'npm_package_id' => ['nullable', 'exists:npm_packages,id'],
            'packagist_package_id' => [
                'nullable',
                'exists:packagist_packages,id',
            ],
        ];
    }
}
