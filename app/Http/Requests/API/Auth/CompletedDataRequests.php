<?php

namespace App\Http\Requests\API\Auth;

use App\Support\JsonFormRequest as FormRequest;

class CompletedDataRequests extends FormRequest
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
        $return = [
            'username'      => "required|string|alpha_dash:ascii|unique:users,username",
            'email'         => "required|email",
            'job_title'     => "required|max:191",
            'password'      => "required|min:6",
            'specialties'   => "required|array",
            'specialties.*' => "required|numeric|exists:specialties,id",
            'interests'     => "required|array",
            'interests.*'   => "required|numeric|exists:specialties,id",
        ];
        if(request()->has("email")) {
            $return["email"] = "required|email";
        }
        return $return;
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
        ];
    }
}
