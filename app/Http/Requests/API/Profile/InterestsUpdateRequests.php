<?php

namespace App\Http\Requests\API\Profile;

use App\Support\JsonFormRequest as FormRequest;

class InterestsUpdateRequests extends FormRequest
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
            'interests'   => "required|array",
            'interests.*' => "required|numeric|exists:specialties,id",
        ];
    }
}
