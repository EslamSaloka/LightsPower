<?php

namespace App\Http\Requests\API\Post;

use App\Support\JsonFormRequest as FormRequest;

class PostRequests extends FormRequest
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
        $return = [
            // 'thread'              => "required|in:0,1",
        ];
        // if(request("thread",0) == 1) {
        //     $return['description']            = "required";
        // } else {
        //     $return['description']            = "required|max:286";
        // }
        $return['description']            = "required|max:286";
        if(request()->has("images")) {
            $return['images']            = "required|array";
            $return['images.*']          = "required|image";
        }
        return $return;
    }
}
