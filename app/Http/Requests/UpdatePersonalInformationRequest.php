<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalInformationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_name' => 'sometimes|string|max:255',
            'gender_id' => 'sometimes|exists:genders,id',
            'date_of_birth' => 'sometimes|date',
            'phone_number' => 'sometimes|string|max:20',
            'email' => 'sometimes|email|max:255',
            'marital_status_id' => 'sometimes|exists:marital_statuses,id',
            'father_name' => 'sometimes|string|max:255',
            'mother_name' => 'sometimes|string|max:255',
            'passport_number' => 'nullable|string|max:50',
            'passport_issued_date' => 'nullable|date',
            'passport_expiry_date' => 'nullable|date|after:passport_issued_date',
            'postal_address' => 'sometimes|string',
            'is_completed' => 'sometimes|boolean',
        ];
    }
}