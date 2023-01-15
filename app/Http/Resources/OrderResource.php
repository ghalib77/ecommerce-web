<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ProductResource;
use App\Http\Resources\UserResource;

class OrderResource extends JsonResource
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
            'product'=>new ProductResource($this->whenLoaded('product')),
            'quantity'=>$this->quantity,
            'payment_method'=>$this->payment_method,
            'user'=>new UserResource($this->whenLoaded('user'))
        ];
    }
}
