<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorStoreRequest extends FormRequest
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
            'avatar' => ['nullable', 'file'],
            'description' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'max:255', 'string'],
            'github' => ['nullable', 'max:255', 'string'],
            'packagist' => ['nullable', 'max:255', 'string'],
            'npm' => ['nullable', 'max:255', 'string'],
            'owner_id' => ['nullable', 'exists:owners,id'],
            'organization_id' => ['nullable', 'exists:organizations,id'],
        ];
    }
}
