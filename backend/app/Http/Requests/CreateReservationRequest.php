<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateReservationRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'event_space_id' => 'required|exists:event_spaces,id',
            'event_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'end_time' => 'required|date_format:Y-m-d H:i:s|after:start_time',
            'status' => 'required|string|in:CONFIRMED,CANCELLED,PENDING',
        ];
    }
    public function messages()
    {
        return [
            'event_space_id.required' => 'The event space is required.',
            'event_space_id.exists' => 'The selected event space does not exist.',
            'event_name.required' => 'The event name is required.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'The start time must be a valid date and format as Y-m-d H:i:s.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'The end time must be a valid date and format as Y-m-d H:i:s.',
            'end_time.after' => 'The end time must be after the start time.',
            'status.required' => 'The status is required.',
            'status.in' => 'The selected status is invalid. It should be CONFIRMED,CANCELLED or PENDING.',
        ];
    }
    
}
