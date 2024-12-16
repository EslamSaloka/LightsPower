<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class UserAccountResources extends JsonResource
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
        $chat_id = 0;
        if(Auth::check()) {
            if(Auth::user()->id != $this->id) {
                $chat = Chat::where("user_id",$this->id)->where("user2_id",Auth::user()->id)->orWhere("user2_id",$this->id)->where("user_id",Auth::user()->id)->first();
                if(!is_null($chat)) {
                    $chat_id = $chat->id;
                }
            }
        }
        return [
            "id"                    => $this->id,
            'username'              => $this->username,
            'email'                 => $this->email ?? '',
            'phone'                 => $this->phone,
            'bio'                   => $this->bio ?? '',
            'job_title'             => $this->job_title ?? '',
            'posts'                 => $this->posts()->where("parent",0)->count(),
            'stories'               => $this->story()->count(),
            'followers'             => $this->myFollower()->count(),
            'following'             => $this->iFollow()->count(),
            "avatar"                => $this->display_avatar,
            "cover"                 => $this->display_cover,
            "last_action_at"        => $time,
            'chat_id'               => $chat_id,
        ];
    }
}
