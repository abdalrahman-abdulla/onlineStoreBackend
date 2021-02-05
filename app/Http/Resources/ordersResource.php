<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ordersResource extends JsonResource
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
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'customer_name' => $this->name,
            'location' => $this->location,

        ];
    }
}
