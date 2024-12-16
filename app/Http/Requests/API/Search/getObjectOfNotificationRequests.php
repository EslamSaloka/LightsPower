<?php

namespace App\Http\Requests\API\Search;

use App\Support\JsonFormRequest as FormRequest;

class getObjectOfNotificationRequests extends FormRequest
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
            'model_id'     => 'required|numeric',
            'model_type'   => 'required|in:follow,un-follow,post-like,post-comment,post-comment-replay,post-comment-like,post-mention,comment-mention,story-mention,story-like',
        ];
    }
}
