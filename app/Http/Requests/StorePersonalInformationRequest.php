<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonalInformationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_name' => 'required|string|max:255',
            'gender_id' => 'required|exists:genders,id',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'marital_status_id' => 'required|exists:marital_statuses,id',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'passport_number' => 'nullable|string|max:50',
            'passport_issued_date' => 'nullable|date',
            'passport_expiry_date' => 'nullable|date|after:passport_issued_date',
            'postal_address' => 'required|string',
        ];
    }
}