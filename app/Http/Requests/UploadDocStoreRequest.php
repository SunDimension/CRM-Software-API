<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocStoreRequest extends FormRequest
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
            'subfolder_id' => ['required', 'integer', 'exists:subfolders,id'],
            'filetype_id' => ['required', 'integer', 'exists:file_types,id'],
            'file_title' => ['nullable', 'string', 'max:255'],
            'file_description' => ['nullable', 'string', 'max:1000'],
            'financial_value' => ['nullable', 'numeric', 'min:0'],
            'file_expiry_date' => ['nullable', 'date', 'after:today'],
            'attach_file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg', 'max:10240'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            'subfolder_id.required' => 'Subfolder is required.',
            'subfolder_id.exists' => 'The selected subfolder does not exist.',
            'filetype_id.required' => 'File type is required.',
            'filetype_id.exists' => 'The selected file type does not exist.',
            'file_title.max' => 'File title must not exceed 255 characters.',
            'file_description.max' => 'File description must not exceed 1000 characters.',
            'financial_value.numeric' => 'Financial value must be a valid number.',
            'financial_value.min' => 'Financial value cannot be negative.',
            'file_expiry_date.date' => 'Expiry date must be a valid date.',
            'file_expiry_date.after' => 'Expiry date must be a future date.',
            'attach_file.required' => 'A file attachment is required.',
            'attach_file.mimes' => 'The file must be one of the following formats: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG.',
            'attach_file.max' => 'The file must not exceed 10MB.',
        ];
    }
}
