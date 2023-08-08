<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VersionUpdateRequest extends FormRequest
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
            'version' => ['required', 'max:255', 'string'],
            'item_id' => ['required', 'exists:items,id'],
        ];
    }
}
