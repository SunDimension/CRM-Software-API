<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentApplicationStoreRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:students,email',
            'fathers_name' => 'nullable|string|max:255',
            'mothers_name'=> 'nullable|string|max:255',
            'gender_id'=>'required|exist:genders,id',
        ];
    }
}
