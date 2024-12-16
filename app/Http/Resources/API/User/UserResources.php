<?php

namespace App\Http\Resources\API\User;

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
        $time = \Carbon\Carbon::parse($this->last_action_at) ?? null;
        if(is_null($time)) {
            $time = '';
        } else {
            if($time->subMinutes(5)->isPast() && $time->addMinutes(6)->isFuture()) {
                $time = 'متواجد الأن';
            } else {
                $time = $time->addMinutes(5)->diffForHumans();
            }
        }
        return [
            "id"                    => $this->id,
            'username'              => $this->username,
            'email'                 => $this->email ?? '',
            'phone'                 => $this->phone,
            'phone_verified'        => (is_null($this->phone_verified_at)) ? false:true,
            'bio'                   => $this->bio ?? '',
            'job_title'             => $this->job_title ?? '',
            'posts'                 => $this->posts()->where("parent",0)->count(),
            'stories'               => $this->story()->count(),
            'followers'             => $this->myFollower()->count(),
            'following'             => $this->iFollow()->count(),
            'notifications'         => $this->notifications()->where("seen",0)->count(),
            "avatar"                => $this->display_avatar,
            "cover"                 => $this->display_cover,
            "last_action_at"        => $time,
        ];
    }
}
