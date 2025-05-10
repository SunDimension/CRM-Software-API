<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LevelOfStudyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:level_of_studies,name',
        ];
    }
}
