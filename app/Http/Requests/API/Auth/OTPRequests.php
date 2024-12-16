<?php

namespace App\Http\Requests\API\Auth;

use App\Support\JsonFormRequest as FormRequest;

class OTPRequests extends FormRequest
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
            'phone' => "required|numeric|unique:users,phone",
        ];
    }

    public function messages() {
        return [
            "phone.required"    => "برجاء إدخال رقم الجوال",
            "phone.numeric"    => "نأسف ولكن رقن الجوال يجيب ان يكون رقما",
            "phone.unique"    => "رقم الجوال مستخدم من قبل",
        ];
    }
}
