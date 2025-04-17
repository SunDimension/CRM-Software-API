<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationalQualificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'qualification_name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'qualification_obtained' => 'required|string|max:255',
            'grade' => 'required|string|max:50',
            'institution_name' => 'required|string|max:255',
            'year_started_id' => 'required|exists:years,id',
            'qualification_order' => 'required|integer|min:1|max:3',
        ];
    }
}