<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Set to false if using auth checks
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:social_media,name',
        ];
    }
}
