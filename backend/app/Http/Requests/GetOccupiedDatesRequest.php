<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetOccupiedDatesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'start' => 'required|date|before_or_equal:end',
            'end' => 'required|date|after_or_equal:start',
        ];
    }

    public function messages(): array
    {
        return [
            'start.required' => 'The start date is required.',
            'start.date' => 'The start date must be a valid date.',
            'start.before_or_equal' => 'The start date must be before or equal to the end date.',
            'end.required' => 'The end date is required.',
            'end.date' => 'The end date must be a valid date.',
            'end.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }
}
