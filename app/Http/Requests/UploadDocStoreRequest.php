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
            
            'filetype_id' => ['required', 'integer', 'exists:file_types,id'],
            'file_title' => ['nullable', 'string', 'max:255'],
            'application_id' => ['required', 'integer', 'exists:student_personal_information,id'],
            'is_completed' => ['nullable', 'boolean'],
            'attach_file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg', 'max:10240'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            
            'attach_file.required' => 'A file attachment is required.',
            'attach_file.mimes' => 'The file must be one of the following formats: PDF, DOC, DOCX, XLS, XLSX, PNG, JPG, JPEG.',
            'attach_file.max' => 'The file must not exceed 10MB.',
        ];
    }
}