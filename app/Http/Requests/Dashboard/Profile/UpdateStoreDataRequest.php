<?php

namespace App\Http\Requests\Dashboard\Profile;

use App\Rules\ValidateUserPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStoreDataRequest extends FormRequest
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
            'username'                  => 'required',
            'store_name'                => 'required',
            // 'my_fatoorah_api_key'       => 'required',
            // 'bio'                       => 'required',
            'short_description'         => 'required',
            // 'vat'         => 'required',
            'terms_information'         => 'required',
            'return_information'        => 'required',
            'email'                     => 'required|email|max:250',
            'phone'                     => 'required|numeric',
            'photo'                     => 'nullable|image|max:10240',
            'cover'                     => 'nullable|image|max:10240',
        ];
    }

    public function messages() {
        return [
            "username.required"    => "برجاء إدخال إسم المستخدم",
            "store_name.required" => "برجاء إدخال إسم المتجر",
            "bio.required" => "برجاء إدخال نبذه عن المتجر",
            "short_description.required" => "برجاء إدخال وصف المتجر",
            "terms_information.required" => "برجاء إدخال معلومات المتجر",
            "return_information.required" => "برجاء إدخال سياسة المتجر",
            "email.required" => "برجاء إدخال البريد الإلكتروني للمتجر",
            "phone.required"    => "برجاء إدخال رقم الجوال",
            "phone.numeric"    => "نأسف ولكن رقم الجوال يجيب ان يكون رقما",
            "photo.required" => "برجاء إدخال صوره للمتجر",
            "cover.required" => "برجاء إدخال كافر المتجر",
        ];
    }
}
