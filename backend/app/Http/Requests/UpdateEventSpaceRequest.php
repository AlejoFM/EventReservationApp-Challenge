<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventSpaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     */    
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'capacity' => 'sometimes|required|integer',
            'type' => 'sometimes|required|string',
            'location' => 'sometimes|required|string',
            'status' => 'sometimes|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'capacity.required' => 'The capacity field is required.',
            'type.required' => 'The type field is required.',
            'location.required' => 'The location field is required.',
            'status.string' => 'The status must be a string.',
        ];
    }
}
