<?php

namespace App\Http\Resources\API\Chat;

use App\Models\Post;
use App\Models\Product;
use App\Models\Story;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $u = $this->user;
        $n      = $this->user->username;
        $image  = $this->user->display_avatar;
        $user = [
            "id"        => $u->id,
            "name"      => $n,
            "avatar"    => $image,
        ];
        $object = null;
        if($this->type == "story") {
            $story = Story::find($this->message);
            if(!is_null($story)) {
                $object = [
                    "id"            => $story->id,
                    "title"         => $story->description,
                    "main_image"    => $story->display_image,
                ];
            }
        } else if($this->type == "post") {
            $post = Post::find($this->message);
            if(!is_null($post)) {
                $object = [
                    "id"            => $post->id,
                    "title"         => $post->description,
                    "main_image"    => $post->display_main_image,
                ];
            }
        }
        return [
            "id"                => $this->id,
            "user"              => $user,
            "type"              => $this->type,
            "object"            => $object,
            "message"           => $this->message ?? '',
            "sendByMe"          => ($this->user_id == \Auth::user()->id) ? true : false ,
            "created_at"        => $this->created_at->diffForHumans(),
        ];
    }
}
