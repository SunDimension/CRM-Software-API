<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalInformationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'application_id' => 'required|unique:student_personal_information,application_id',
        'gender_id' => 'required|exists:genders,id',
        'marital_status_id' => 'nullable|exists:marital_statuses,id',
        'student_name' => 'required|string',
        'date_of_birth' => 'required|date',
        'phone_number' => 'required|string',
        'email' => 'required|email',
        'father_name' => 'nullable|string',
        'mother_name' => 'nullable|string',
        'passport_number' => 'nullable|string',
        'passport_issued_date' => 'nullable|date',
        'passport_expiry_date' => 'nullable|date',
        'postal_address' => 'nullable|string',
    ];
}

}