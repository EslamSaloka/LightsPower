<?php

namespace App\Http\Requests\Dashboard\User;

use App\Rules\ValidateUserName;
use App\Rules\ValidateUserPassword;
use App\Rules\ValidateUserPhone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->user->id;
        return [
            'username'  => 'required|string|max:30|unique:users,username,'.$id.',id',
            'email'  => 'required|email|max:250|unique:users,email,'.$id.',id',
            'phone'  => ['required', 'numeric','unique:users,phone,'.$id.',id'],
            'password' => ['nullable', 'max:20', 'regex:/^\S*(?=\S{8,})(?=\S*[a-zA-Zي-أ])(?=\S*[0-9])(?=\S*[!@#$%^&*])\S*$/'],
            'role' =>   'required|exists:roles,name',
            'avatar' => 'nullable|image|max:10240',
            'cover' => 'nullable|image|max:10240',
            'suspend' => 'nullable|boolean'
        ];
    }
}
