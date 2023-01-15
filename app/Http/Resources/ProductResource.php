<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\StoreResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\OrderResource;

class ProductResource extends JsonResource
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
            "photo_product"=>$this->photo_product,
            "description"=>$this->description,
            "quantity"=>$this->quantity,
            "product_rating"=>$this->product_rating,
            "category"=>new CategoryResource($this->whenLoaded('category')),
            "store"=>new StoreResource($this->whenLoaded('store')),
            "order"=>OrderResource::collection($this->whenLoaded('order')),
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s')
        ];
    }
}
