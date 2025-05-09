<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsUpdateRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'referred_by' => 'nullable|string|max:255',
        'social_media_id' => 'nullable|exists:social_media,id',
        'sponsor_parent_guardian' => 'nullable|string|max:255',
        'sponsor_government' => 'nullable|string|max:255',
        'sponsor_ngo' => 'nullable|string|max:255',
        'sponsor_self' => 'nullable|string|max:255',
    ];
}

}
