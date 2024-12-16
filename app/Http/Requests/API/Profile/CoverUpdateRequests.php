<?php

namespace App\Http\Requests\API\Profile;

use App\Support\JsonFormRequest as FormRequest;

class CoverUpdateRequests extends FormRequest
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
            'cover'      => 'required|image',
        ];
    }
}
