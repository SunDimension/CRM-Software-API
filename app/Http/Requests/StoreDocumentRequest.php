<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'document_name' => 'required|string|max:255',
            'document_type' => 'required|string|max:255',
            'file' => 'required|file|max:10240', // 10MB max
        ];
    }
}