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
        'qualifications' => 'required|array|min:1',
        'qualifications.*.qualification_name' => 'required|string|max:255',
        'qualifications.*.country_id' => 'required|exists:countries,id',
        'qualifications.*.qualification_obtained_id' => 'required|exists:level_of_studies,id',
        'qualifications.*.grade' => 'required|string|max:255',
        'qualifications.*.institution_name' => 'required|string|max:255',
        'qualifications.*.year_started_id' => 'required|exists:years,id',
        'qualifications.*.year_finished_id' => 'required|exists:years,id',
        'qualifications.*.qualification_order' => 'required|integer',
        'qualifications.*.is_completed' => 'required|boolean',
    ];
}

}