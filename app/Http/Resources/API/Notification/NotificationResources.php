<?php

namespace App\Http\Resources\API\Notification;

use App\Http\Resources\API\Post\CommentResources;
use App\Http\Resources\API\Post\PostResources;
use App\Http\Resources\API\Story\StoryResources;
use App\Http\Resources\API\Story\UserResources;
use App\Http\Resources\API\User\ShortUserResources;
use App\Models\Post;
use App\Models\Post\Comment;
use App\Models\Story;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResources extends JsonResource
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
            "id"            => $this->id,
            'body'          => $this->body,
            "made_by"       => new ShortUserResources($this->user2),
            'model_type'    => $this->model_type,
            // 'model_id'      => $this->model_id,
            "data"          => $this->getData(),
            'seen'          => ($this->seen == true) ? true : false,
            "created_at"    => $this->created_at->diffForHumans(),
            // "user"          => new UserResources($this->user2),
        ];
    }

    private function getData() {
        if($this->model_type == "post-comment-replay" || $this->model_type == "post-comment" || $this->model_type == "post-comment-like" || $this->model_type == "comment-mention" || $this->model_type == "post-comment-reply-like") {
            return new CommentResources(Comment::find($this->model_id)) ?? [];
        }
        if($this->model_type == "post" || $this->model_type == "post-like" || $this->model_type == "post-mention") {
            return new PostResources(Post::find($this->model_id)) ?? [];
        }
        if($this->model_type == "follow" || $this->model_type == "un-follow") {
            return new PostResources(Post::find($this->model_id)) ?? [];
        }
        if($this->model_type == "story-mention" || $this->model_type == "story-like") {
            return new StoryResources(Story::find($this->model_id)) ?? [];
        }
        return [];
    }
}
