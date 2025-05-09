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
            'first_choice' => 'required|string|max:255', // Validate First Choice
            'second_choice' => 'required|string|max:255|different:first_choice', // Validate Second Choice
            'third_choice' => 'required|string|max:255|different:first_choice|different:second_choice', // Validate Third Choice
        ];
    }
}