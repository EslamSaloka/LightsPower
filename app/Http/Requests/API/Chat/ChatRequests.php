<?php

namespace App\Http\Requests\API\Chat;

use App\Support\JsonFormRequest as FormRequest;

class ChatRequests extends FormRequest
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
            'user_id'   => 'required|numeric|exists:users,id',
            // 'user_type' => 'required|in:default,store',
            'message'   => 'required',
            'type'      => 'required|in:text,post,story,product',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'   => 'برجاء إدخال المرسل إليه ',
            'message.required'   => 'برجاء إدخال الرسالة ',
            'type.required'      => 'برجاء إدخال نوع الرسالة',
        ];
    }
}
