<?php

namespace App\Http\Resources\API\Intros;

use Illuminate\Http\Resources\Json\JsonResource;

class IntrosResources extends JsonResource
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
            "description"       => $this->description,
            "image"             => $this->display_image,
        ];
    }
}
