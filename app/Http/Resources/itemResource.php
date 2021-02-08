<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\subcategoryResource;
use App\Subcategory;
use App\Http\Resources\categoryResource;

class itemResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->getImageFromGoogleDrive(),
            'price' => $this->price,
            'quantity' => $this->quantity,
            'slug' => $this->slug,
            'subcategory' => new subcategoryResource(Subcategory::findOrFail($this->subcategory_id)),
            'category' => new categoryResource(Subcategory::findOrFail($this->subcategory_id)->category),
            'created_at' => $this->created_at
        ];

    }
}
