<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsStoreRequest extends FormRequest
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
        'referred_by' => 'nullable|string|max:255',
        'social_media_id' => 'nullable|exists:social_media,id',
        'sponsor_parent_guardian' => 'nullable|string|max:255',
        'sponsor_government' => 'nullable|string|max:255',
        'sponsor_ngo' => 'nullable|string|max:255',
        'sponsor_self' => 'nullable|string|max:255',
    ];
}

}


