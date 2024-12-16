<?php

namespace App\Http\Resources\API\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lastMessage = [];
        $user        = [];
        $last        = $this->messages()->orderBy("id","desc")->first();
        $lastDate    = '';


        if(!is_null($last)) {
            $message = $last->message;
            if($last->type == "image") {
                $message = url($last->message);
            }


            $n = $last->user->username;

            $lastMessage = [
                "sendBy"    => (\Auth::user()->id == $last->user_id) ? "you" : $n,
                "message"   => $message,
                "type"      => $last->type,
                "seen"      => ($last->seen == 1) ? true : false,
            ];
            $lastDate    = $last->created_at->diffForHumans();
        }

        if((int)$this->user_id != (int)\Auth::user()->id) {

            $nn      = $this->user->username ?? '';
            $image  = $this->user->display_avatar;
            $user = [
                "id"        => $this->user_id,
                "name"      => $nn,
                "avatar"    => $image,
            ];

        }

        if((int)$this->user2_id != (int)\Auth::user()->id) {

            $n      = $this->user2->username ?? '';
            $image  = $this->user2->display_avatar;
            $user = [
                "id"        => $this->user2->id,
                "name"      => $n,
                "avatar"    => $image,
            ];
        }


        return [
            "id"                => $this->id,
            "user"              => $user,
            "last_message"      => $lastMessage,
            "lastDate"          => $lastDate,
        ];
    }
}
