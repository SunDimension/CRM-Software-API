<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrimaryFolderUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'year_id' => ['required', 'integer', 'exists:years,id'],
             'company_id' => ['required', 'integer', 'exists:companies,id'],
            
           
        ];
    }
}
