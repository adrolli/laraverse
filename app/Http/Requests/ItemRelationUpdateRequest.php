<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRelationUpdateRequest extends FormRequest
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
            'data' => ['required', 'max:255', 'json'],
            'item_id' => ['required', 'exists:items,id'],
            'itemto_id' => ['required', 'max:255'],
            'item_relation_type_id' => [
                'required',
                'exists:item_relation_types,id',
            ],
            'post_id' => ['nullable', 'exists:posts,id'],
        ];
    }
}
