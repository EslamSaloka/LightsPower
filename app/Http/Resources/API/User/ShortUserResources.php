<?php

namespace App\Http\Resources\API\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ShortUserResources extends JsonResource
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
            'job_title'             => $this->job_title ?? '',
            "avatar"                => $this->display_avatar,
            "cover"                 => $this->display_cover,
            "last_action_at"        => $time,
        ];
    }
}
