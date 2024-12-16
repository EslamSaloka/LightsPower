<?php

namespace App\Http\Resources\API\Post;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Story\UserResources;

class LikeResources extends JsonResource
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
            "id"         => $this->id,
            "user"       => new UserResources($this->user),
            "created_at" => $this->created_at->diffForHumans(),
        ];
    }
}
