<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            'id'=>$this->id,
            'card_number'=>$this->card_number,
            'card_type'=>$this->card_type,
            'cvv'=>$this->cvv,
            'expired_date'=>$this->expired_date,
        ];
    }
}
