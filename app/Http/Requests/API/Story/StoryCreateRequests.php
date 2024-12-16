<?php

namespace App\Http\Requests\API\Story;

use App\Support\JsonFormRequest as FormRequest;

class StoryCreateRequests extends FormRequest
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
            'specialty_id'  => 'required|numeric|exists:specialties,id',
            'description'   => 'required',
            'video'         => 'required|mimes:mp4,mov,ogx,oga,ogv,ogg,webm',
        ];
    }

    public function messages() {
        return [
            "video.mimes" => "برجاء رفع فيديو فقط",
        ];
    }
}
