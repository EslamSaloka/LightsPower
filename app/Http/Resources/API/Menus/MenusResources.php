<?php

namespace App\Http\Resources\API\Menus;

use Illuminate\Http\Resources\Json\JsonResource;

class MenusResources extends JsonResource
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
            "id"   => $this->id,
            "name" => $this->name,
        ];
    }
}
