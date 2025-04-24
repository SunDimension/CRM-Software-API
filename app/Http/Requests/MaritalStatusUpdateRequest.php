<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaritalStatusUpdateRequest extends FormRequest
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
    // app/Http/Requests/UpdateMaritalStatusRequest.php

    public function rules()
 {
        return [
            'name' => 'required|string|unique:marital_statuses,name,' . $this->route('marital_status')->id,
        ];
    }

}
