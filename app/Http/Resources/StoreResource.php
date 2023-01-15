<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

class StoreResource extends JsonResource
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
          "id"=>$this->id,
          "name"=>$this->name,
          "store_image"=>$this->store_image,
          "location"=>$this->location,
          "product"=>ProductResource::collection($this->whenLoaded('product'))
        ];
    }
}
