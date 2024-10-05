<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventSpaceFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'type' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date|before_or_equal:end_date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'size' => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'type.string' => 'The type must be a string.',
            'capacity.integer' => 'The capacity must be an integer.',
            'capacity.min' => 'The capacity must be at least 1.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.before_or_equal' => 'The start date must be before or equal to the end date.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'size.integer' => 'The size must be a valid integer.',
            'size.min' => 'The size must be at least 1.'
        ];
    }
}
