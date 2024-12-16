<?php

namespace App\Http\Resources\API\Post;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Story\UserResources;
use App\Http\Resources\API\Post\ImageResources;
use App\Http\Resources\API\Post\ThreadResources;

class PostResources extends JsonResource
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
            'is_liked'          => isObjectLiked($this->id,"post"),
            "likes"             => $this->likes()->count(),
            "comments"          => $this->comments()->count(),
            "shares"            => $this->shares()->count(),
            "images"            => ImageResources::collection($this->images),
            "created_at"        => $this->created_at->diffForHumans(),
            // "threads"           => ThreadResources::collection($this->threads),
            "mentions"              => $this->getMentionsUsers(),
            "tags"                  => $this->getTags(),
        ];
    }
}
