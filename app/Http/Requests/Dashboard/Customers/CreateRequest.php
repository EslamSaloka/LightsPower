<?php

namespace App\Http\Requests\Dashboard\Customers;

use App\Rules\ValidateUserName;
use App\Rules\ValidateUserPassword;
use App\Rules\ValidateUserPhone;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    use UsersMessages;
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
            'username'  => 'required|string|max:30|unique:users,username',
            'email'  => 'required|email|max:250|unique:users,email',
            'phone'  => ['required', 'numeric', 'digits_between:1,12', 'unique:users,phone'],
            'password' => ['required', 'max:20', 'regex:/^\S*(?=\S{8,})(?=\S*[a-zA-Zي-أ])(?=\S*[0-9])(?=\S*[!@#$%^&*])\S*$/'],
            'avatar' => 'nullable|image|max:10240',
            'suspend' => 'nullable|boolean'
        ];
    }
    
    public function messages() {
        return [
            "username.required"  => "برجاء إدخال إسم المستخدم",
            "username.string"    => "برجاء إدخال جمل",
            "username.unique"    => "إسم المستخدم مسنخدم من قبل",
            // ======================== //
            "email.required"  => "برجاء إدخال البريد الإلكتروني",
            "email.unique"    => "البريد الإلكتروني مسنخدم من قبل",
            // ======================== //
        ];
    }
}
