<?php

namespace App\Http\Requests\Dashboard\Stories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $return =  [
            'description'       => 'required|string',
        ];
        if(request()->has("image")) {
            $return["image"] = 'required|mimes:mp4';
        }
        return $return;
    }
}
