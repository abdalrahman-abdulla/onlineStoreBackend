<?php

namespace App\Http\Resources;
use App\Http\Resources\userResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\singleOrderItemResource;

class orderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'order_no' => $this->id,
            'user' => new userResource($this->user),
            'total_price' => $this->total_price,
            'items' => singleOrderItemResource::collection($this->items),
            'created_at' => $this->created_at,
            'phone' => $this->phone,
            'customer_name' => $this->name,
            'location' => $this->location,

        ];
    }
}
