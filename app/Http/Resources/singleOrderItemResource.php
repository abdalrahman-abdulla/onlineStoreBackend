<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class singleOrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'quantity'=>$this->pivot->quantity
        ];

    }
}
