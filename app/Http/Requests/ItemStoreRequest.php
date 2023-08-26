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
            'latest_version' => ['nullable', 'max:255', 'string'],
            'versions' => ['nullable', 'max:255', 'json'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'itemType_id' => ['required', 'exists:item_types,id'],
            'website' => ['nullable', 'max:255', 'string'],
            'ranking' => ['nullable', 'numeric'],
            'popularity' => ['nullable', 'numeric'],
            'popularity_data' => ['nullable', 'max:255', 'json'],
            'rating' => ['nullable', 'numeric'],
            'rating_data' => ['nullable', 'max:255', 'json'],
            'health' => ['nullable', 'numeric'],
            'health_data' => ['nullable', 'max:255', 'json'],
            'github_url' => ['nullable', 'max:255', 'string'],
            'github_stars' => ['nullable', 'numeric'],
            'packagist_url' => ['nullable', 'max:255', 'string'],
            'packagist_name' => ['nullable', 'max:255', 'string'],
            'packagist_description' => ['nullable', 'max:255', 'string'],
            'packagist_downloads' => ['nullable', 'numeric'],
            'packagist_favers' => ['nullable', 'numeric'],
            'npm_url' => ['nullable', 'max:255', 'string'],
            'github_maintainers' => ['nullable', 'numeric'],
            'php_compatibility' => ['nullable', 'max:255', 'json'],
            'laravel_compatibilty' => ['nullable', 'max:255', 'json'],
            'repository_id' => ['nullable', 'exists:repositories,id'],
            'npm_package_id' => ['nullable', 'exists:npm_packages,id'],
            'packagist_package_id' => [
                'nullable',
                'exists:packagist_packages,id',
            ],
        ];
    }
}
