<?php

namespace App\Http\Resources\API\Story;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Specialties\SpecialtiesResources;
use App\Http\Resources\API\Story\UserResources;

class StoryResources extends JsonResource
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
            'user'                  => new UserResources($this->user),
            'specialty'             => new SpecialtiesResources($this->specialty),
            'description'           => $this->description ?? '',
            "video"                 => $this->video ?? '',
            'is_liked'              => isObjectLiked($this->id,"story"),
            "likes"                 => $this->likes()->count(),
            "views"                 => $this->views()->count(),
            "created_at"            => $this->created_at->diffForHumans(),
            "mentions"              => $this->getMentionsUsers(),
            "tags"                  => $this->getTags(),
        ];
    }
}
