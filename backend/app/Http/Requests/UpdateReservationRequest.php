<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'event_name' => 'sometimes|required|string|max:255',
            'start_time' => 'sometimes|required|date|after:now',
            'end_time' => 'sometimes|required|date|after:start_time',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'event_name.required' => 'The event name is required when provided.',
            'event_name.string' => 'The event name must be a valid string.',
            'event_name.max' => 'The event name must not exceed 255 characters.',
            'start_time.required' => 'The start time is required when provided.',
            'start_time.date' => 'The start time must be a valid date.',
            'start_time.after' => 'The start time must be a date after the current time.',
            'end_time.required' => 'The end time is required when provided.',
            'end_time.date' => 'The end time must be a valid date.',
            'end_time.after' => 'The end time must be a date after the start time.',
        ];
    }
}
