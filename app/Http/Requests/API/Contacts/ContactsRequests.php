<?php

namespace App\Http\Requests\API\Contacts;

use App\Support\JsonFormRequest as FormRequest;

class ContactsRequests extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 'name'      => "required|max:30|string",
            // 'email'     => "required|email",
            // 'phone'     => "required|numeric",
            'message'   => "required|string|max:250",
        ];
    }
}
