<?php

namespace App\Http\Resources\API\Story;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"        => $this->id,
            'username'  => $this->username,
            'job_title' => $this->job_title ?? '',
            "avatar"    => $this->display_avatar,
        ];
    }
}
