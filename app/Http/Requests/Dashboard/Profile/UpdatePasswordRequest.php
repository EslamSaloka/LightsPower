<?php

namespace App\Http\Requests\Dashboard\Profile;

use App\Rules\ValidateUserPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
            'current_password'      => 'required',
            'password'              => ['required', 'max:20'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }

    public function messages()
    {
        return [
            // 'password.regex' => __('كلمه المرور يجيب ان تأكود اكثر من 8 احرف '),
            // 'password.regex' => __('Password should be at least 8 characters, numbers and symbols'),
        ];
    }
}
