<?php

namespace App\Http\Requests\API\Auth;

use App\Support\JsonFormRequest as FormRequest;

class CheckOTPRequests extends FormRequest
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
            'phone'         => "required|numeric|exists:new_account,phone",
            'otp'           => "required|numeric",
            // 'devices_token' => "required",
        ];
    }

    public function messages() {
        return [
            "phone.required"    => "برجاء إدخال رقم الجوال",
            "phone.numeric"    => "نأسف ولكن رقم الجوال يجيب ان يكون رقما",
            "phone.exists"    => "هذا الجوال غير موجود لدينا",
            "otp.numeric"    => "نأسف ولكن كود التحقيق يجيب ان يكون رقما",
        ];
    }
}
