<?php

namespace App\Http\Resources\API\Categories;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Menus\MenusResources;

class CategoriesWithMenuResources extends JsonResource
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
            "id"    => $this->id,
            "name"  => $this->name,
            "menus" => MenusResources::collection($this->menus),
            // "count" => $this->count,
        ];
    }
}
