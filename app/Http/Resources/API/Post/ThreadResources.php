<?php

namespace App\Http\Resources\API\Post;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Story\UserResources;
use App\Http\Resources\API\Post\ImageResources;

class ThreadResources extends JsonResource
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
            "user"              => new UserResources($this->user),
            "description"       => $this->description ?? '',
            "likes"             => $this->likes()->count(),
            "comments"          => $this->comments()->count(),
            "shares"            => $this->shares()->count(),
            "created_at"        => $this->created_at->diffForHumans(),
        ];
    }
}
