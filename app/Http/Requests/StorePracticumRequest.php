<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePracticumRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:practicums,name',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'schedule' => 'nullable|string|max:255',
        ];
    }
}
