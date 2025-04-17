<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramChoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'university_id' => 'required|exists:universities,id',
            'program_id' => 'required|exists:programs,id',
            'priority' => 'required|integer|min:1|max:3',
        ];
    }
}