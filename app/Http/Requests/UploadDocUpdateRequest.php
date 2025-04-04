<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocUpdateRequest extends FormRequest
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
        'subfolder_id' => ['required', 'integer', 'exists:subfolders,id'], // Changed from sub_folder
        'filetype_id' => ['required', 'integer', 'exists:filetypes,id'], // Changed from file_type
        'file_title' => ['nullable', 'string'],
        'file_description' => ['nullable', 'string'],
        'financial_value' => ['nullable', 'numeric'],
        'file_expiry_date' => ['nullable', 'date'],
        'attach_file' => ['sometimes', 'file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg', 'max:10240'], // Changed from required to sometimes
    ];
}
}
