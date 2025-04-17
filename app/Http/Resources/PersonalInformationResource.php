<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalInformationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'student_name' => $this->student_name,
            'gender' => $this->gender->name,
            'date_of_birth' => $this->date_of_birth,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'marital_status' => $this->maritalStatus->name,
            'father_name' => $this->father_name,
            'mother_name' => $this->mother_name,
            'passport_number' => $this->passport_number,
            'passport_issued_date' => $this->passport_issued_date,
            'passport_expiry_date' => $this->passport_expiry_date,
            'postal_address' => $this->postal_address,
            'is_completed' => $this->is_completed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}