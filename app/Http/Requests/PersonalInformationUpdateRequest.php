<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInformationUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'gender_id' => 'sometimes|exists:genders,id',
            'maritalstatus_id' => 'sometimes|exists:marital_statuses,id',
            'student_name' => 'sometimes|string',
            'date_of_birth' => 'sometimes|date',
            'phone_number' => 'sometimes|string',
            'email' => 'sometimes|email',
            'father_name' => 'nullable|string',
            'mother_name' => 'nullable|string',
            'passport_number' => 'nullable|string',
            'passport_expiry_date' => 'nullable|date',
            'postal_address' => 'nullable|string',
        ];
    }
}
