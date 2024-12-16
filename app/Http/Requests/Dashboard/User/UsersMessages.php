<?php

namespace App\Http\Requests\Dashboard\User;

trait UsersMessages
{
    public function messages()
    {
        return [
            'username.regex' => __('Username should be in english characters or numbers only'),
            'username.unique' => __('Username already exists please choose another name'),
            'password.max' => __('Password should not be more than 12 characters and numbers'),
            'password.regex' => __('Password should be at least 8 characters, numbers and symbols'),
            'email.unique' => __('Email already exists please enter another email'),
            'phone.unique' => __('Phone already exists please enter another phone'),
            'phone.regex' => __('Phone number should start with 9665xxxxxxx'),
        ];
    }
}