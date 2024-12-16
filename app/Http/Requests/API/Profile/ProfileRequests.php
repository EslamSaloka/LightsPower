<?php

namespace App\Http\Requests\API\Profile;

use App\Support\JsonFormRequest as FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequests extends FormRequest
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
        $data = [];
        if(request()->has("username")) {
            $data["username"]   = "required|alpha_dash:ascii|unique:users,username,".Auth::user()->id;
        }
        if(request()->has("email")) {
            $data["email"]   = "required|email|unique:users,email,".Auth::user()->id;
        }
        if(request()->has("phone")) {
            $data["phone"]   = "required|unique:users,phone,".Auth::user()->id;
        }
        return $data;
    }

    public function messages() {
        return [
            "username.required"  => "برجاء إدخال إسم المستخدم",
            "username.alpha_dash"    => " صيغة اسم المستخدم غير صحيحة",
            "username.unique"    => "إسم المستخدم مسنخدم من قبل",
            // ======================== //
            "email.required"  => "برجاء إدخال البريد الإلكتروني",
            "email.unique"    => "البريد الإلكتروني مسنخدم من قبل",
            // ======================== //
            "phone.required"  => "برجاء إدخال رقم الجوال",
            "phone.unique"    => "رقم الجوال مسنخدم من قبل",
            // ======================== //
        ];
    }
}
