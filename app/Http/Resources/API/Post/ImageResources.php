<?php

namespace App\Http\Resources\API\Post;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Story\UserResources;

class ImageResources extends JsonResource
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
            "id"                => $this->id,
            "image"            => $this->display_image,
        ];
    }
}
