<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'activity_type' => 'sometimes|string|max:255',
            'has_submission' => 'sometimes|boolean',
            'start_time' => 'sometimes|date',
            'end_time' => 'sometimes|date|after_or_equal:start_time',
            'description' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'practicum_id' => 'sometimes|exists:practicums,id',
        ];
    }
}
