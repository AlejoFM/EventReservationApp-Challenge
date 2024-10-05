<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventSpaceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'type' => 'required|string',
            'location' => 'required|string',
            'status' => 'sometimes|string',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name must not exceed 255 characters.',
            'capacity.required' => 'The capacity is required.',
            'capacity.integer' => 'The capacity must be an integer.',
            'capacity.min' => 'The capacity must be at least 1.',
            'type.required' => 'The type is required.',
            'type.string' => 'The type must be a string.',
            'location.required' => 'The location is required.',
            'location.string' => 'The location must be a string.',
            'status.string' => 'The status must be a string.',
        ];
    }
}
