<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenderUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:genders,name,' . $this->route('gender')->id,
        ];
    }
}

