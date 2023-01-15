<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

use App\Http\Resources\StoreResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request){
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username'=> $this->username,
            'email' => $this->email,
            'gender'=> $this->gender,
            'photo_profile'=> $this->photo_profile,
            'email_verified_at'=> $this->email_verified_at,
            'address'=> $this->address,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'store' => new StoreResource($this->whenLoaded('store'))
        ];
    }
}
