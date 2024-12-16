<?php

namespace App\Http\Requests\Dashboard\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'phone'         => "required|numeric|exists:users,phone",
            'password'      => 'required|min:8',
            'otp'           => 'required|numeric',
        ];
    }

    public function messages() {
        return [
            "phone.required"    => "برجاء إدخال رقم الجوال",
            "phone.numeric"     => "نأسف ولكن رقن الجوال يجيب ان يكون رقما",
            "phone.exists"      => "رقم الجوال غير مسجل لدينا",
            "otp"               => "يجب ان يكون كود التحقق رقما",
            "otp.exists"        => "كود التحقق غير صحيح",
        ];
    }
}
