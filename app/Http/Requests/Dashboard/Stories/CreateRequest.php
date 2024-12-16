<?php

namespace App\Http\Requests\Dashboard\Stories;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'description'       => 'required|string',
            'image'             => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
        ];
    }
}
