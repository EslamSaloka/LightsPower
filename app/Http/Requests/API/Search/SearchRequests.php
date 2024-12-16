<?php

namespace App\Http\Requests\API\Search;

use App\Support\JsonFormRequest as FormRequest;

class SearchRequests extends FormRequest
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
            'text'   => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'text.required'   => 'عن ماذا تبحث',
        ];
    }
}
