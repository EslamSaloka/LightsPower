<?php

namespace App\Http\Resources\API\Post;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Story\UserResources;

class CommentResources extends JsonResource
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
            "id"                    => $this->id,
            "user"                  => new UserResources($this->user),
            "post_id"               => $this->post_id ?? '',
            "comment"               => $this->comment ?? '',
            "comment_reply_count"   => $this->comments()->count() ?? '',
            "comment_likes_count"   => $this->likes()->count() ?? '',
            "created_at"            => $this->created_at->diffForHumans(),
            'is_liked'              => isObjectLiked($this->id,"comment"),
            "mentions"              => $this->getMentionsUsers(),
            "tags"                  => $this->getTags(),
        ];
    }
}
